<?php
/**
 * Created by PhpStorm.
 * User: umitakkaya
 * Date: 04/09/15
 * Time: 18:07
 */

namespace DP;

use DP\Model\AbstractErrorResponse;
use DP\Model\Address;
use DP\Model\AddressesResponse;
use DP\Model\BookingsResponse;
use DP\Model\BookVisitRequest;
use DP\Model\BookVisitResponse;
use DP\Model\CancelVisitResponse;
use DP\Model\DeleteDoctorServiceResponse;
use DP\Model\DeleteSlotsResponse;
use DP\Model\Doctor;
use DP\Model\DoctorService;
use DP\Model\DoctorServicesResponse;
use DP\Model\DoctorsResponse;
use DP\Model\Error;
use DP\Model\Facility;
use DP\Model\FacilitiesResponse;
use DP\Model\PutSlotsRequest;
use DP\Model\PutSlotsResponse;
use DP\Model\ServicesResponse;
use DP\Model\Slot;
use DP\Model\SlotsResponse;
use Guzzle\Http\Client;
use Guzzle\Http\Exception\BadResponseException;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use JMS\Serializer\DeserializationContext;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\Serializer;


class DPClient
{
	public static $PREFIXES = [
		'pl' => 'https://www.znanylekarz.pl/api/v2/integration/',
		'tr' => 'https://www.eniyihekim.com/api/v2/integration/'
	];


	/** @var string */
	private $clientId;

	/** @var string */
	private $clientSecret;

	/** @var Client */
	private $client;

	/** @var string */
	private $token;

	/** @var \DateTime */
	private $tokenExpirationDate;

	/** @var Serializer */
	private $serializer;

	/**
	 * DPClient constructor.
	 *
	 * @param Serializer $serializer
	 * @param string     $locale
	 */
	public function __construct($serializer, $locale = "pl")
	{
		$requestOptions   = [
			'headers' => ['Content-Type' => 'application/json'],
		];

		$this->serializer = $serializer;
		$this->client     = new Client(self::$PREFIXES[$locale], ['request.options' => $requestOptions]);
	}

	/**
	 * @return string
	 */
	public function getClientSecret()
	{
		return $this->clientSecret;
	}

	/**
	 * @param string $clientSecret
	 *
	 * @return $this
	 */
	public function setClientSecret($clientSecret)
	{
		$this->clientSecret = $clientSecret;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getClientId()
	{
		return $this->clientId;
	}

	/**
	 * @param string $clientId
	 *
	 * @return $this
	 */
	public function setClientId($clientId)
	{
		$this->clientId = $clientId;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getTokenExpirationDate()
	{
		return $this->tokenExpirationDate;
	}

	/**
	 * @param \DateTime $tokenExpirationDate
	 */
	public function setTokenExpirationDate($tokenExpirationDate)
	{
		$this->tokenExpirationDate = $tokenExpirationDate;
	}


	/**
	 * @return string
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * @param string $token
	 *
	 * @return $this
	 */
	public function setToken($token)
	{
		$this->token = $token;
		$this->client->setDefaultOption('headers/Authorization', 'Bearer ' . $this->token);

		return $this;
	}

	public function isAuthorized()
	{
		if ($this->getTokenExpirationDate() === null)
		{
			return $this->token !== null;
		}
		else
		{
			return $this->token !== null && $this->tokenExpirationDate > (new \DateTime);
		}
	}


	/**
	 * @return string Access Token for DP API
	 */
	public function authorize()
	{
		if ($this->token === null)
		{
			$rsp = $this->client->post('/oauth/v2/token', [], [
				'grant_type'    => 'client_credentials',
				'scope'         => 'integration',
				'client_id'     => $this->clientId,
				'client_secret' => $this->clientSecret
			])->send()->json();

			$expiresIn                 = $rsp['expires_in'];
			$this->tokenExpirationDate = (new \DateTime)->setTimestamp($expiresIn);

			$this->setToken($rsp['access_token']);
		}

		return $this->token;
	}


	/**
	 * @param RequestInterface       $request
	 *
	 * @param string                 $className If you omit this parameter you will get Response object
	 * @param DeserializationContext $context
	 *
	 * @return FacilitiesResponse|Facility|Address|AddressesResponse|DoctorsResponse|Doctor|DoctorServicesResponse|ServicesResponse|BookingsResponse|BookVisitResponse|PutSlotsResponse|SlotsResponse|Response
	 * @throws \Exception
	 */
	private function authorizedRequest(RequestInterface $request, $className = null, DeserializationContext $context = null)
	{

		/** @var FacilitiesResponse|Facility|Address|AddressesResponse|DoctorsResponse|Doctor|DoctorServicesResponse|ServicesResponse|BookingsResponse|BookVisitResponse|PutSlotsResponse|SlotsResponse $object */
		/** @var Error $error */
		$object   = null;
		$response = null;
		$error    = null;

		if ($this->isAuthorized() === false)
		{
			$error = (new Error)->setCode(403)
				->setMessage('Token is neither valid nor authorized');;
		}

		try
		{
			$response = $this->client->send($request);
		}
		catch (BadResponseException $e)
		{
			/*
			 * You may want to tolerate 40x errors,
			 * For example:
			 * - If parameters can't be validated you will receive 400
			 * - If there isn't any item to show, you will receive 404
			 * - If you try to access unauthorized doctor or facility or address you will receive 403
			 */

			$response   = $e->getResponse();
			$statusCode = $response->getStatusCode();

			$error = $this->serializer->deserialize($response->getBody(true), Error::class, 'json');
			$error->setCode($statusCode);
		}

		//We don't know expected return type so just return raw response.
		if ($className === null)
		{
			return $response;
		}

		//If there was an error, instantiate the expected class and set the actual Error object;
		//If not then we should simply return the expected class instance with data.
		if ($error === null)
		{
			$object = $this->serializer->deserialize($response->getBody(true), $className, 'json');
		}
		else
		{
			$object = new $className();
			$object->setError($error);
		}

		return $object;
	}


	/**
	 * @return FacilitiesResponse
	 */
	public function getFacilities()
	{
		$request    = $this->client->get('facilities');
		$facilities = $this->authorizedRequest($request, FacilitiesResponse::class);

		return $facilities;
	}

	/**
	 * @param int $facilityId
	 *
	 * @return Facility
	 */
	public function getFacility($facilityId)
	{
		/** @var Facility $facility */
		$request  = $this->client->get(['facilities/{facilityId}', ['facilityId' => $facilityId]]);
		$facility = $this->authorizedRequest($request, Facility::class);

		return $facility;
	}

	/**
	 * @param int $facilityId
	 *
	 * @return DoctorsResponse
	 */
	public function getDoctors($facilityId)
	{

		/** @var DoctorsResponse $doctors */
		$request = $this->client->get(['facilities/{facilityId}/doctors', ['facilityId' => $facilityId]]);
		$doctors = $this->authorizedRequest($request, DoctorsResponse::class);

		return $doctors;
	}

	/**
	 * @param int $facilityId
	 * @param int $doctorId
	 *
	 * @return Doctor
	 */
	public function getDoctor($facilityId, $doctorId)
	{

		/** @var Doctor $doctor */
		$request = $this->client->get([
			'facilities/{facilityId}/doctors/{doctorId}', [
				'facilityId' => $facilityId,
				'doctorId'   => $doctorId
			]
		]);
		$doctor  = $this->authorizedRequest($request, Doctor::class);

		return $doctor;
	}

	/**
	 * @param int $facilityId
	 * @param int $doctorId
	 *
	 * @return AddressesResponse
	 */
	public function getAddresses($facilityId, $doctorId)
	{
		/** @var AddressesResponse $addresses */
		$request   = $this->client->get([
			'facilities/{facilityId}/doctors/{doctorId}/addresses', [
				'facilityId' => $facilityId,
				'doctorId'   => $doctorId
			]
		]);
		$addresses = $this->authorizedRequest($request, AddressesResponse::class);


		return $addresses;
	}

	/**
	 * @param int $facilityId
	 * @param int $doctorId
	 * @param int $addressId
	 *
	 * @return Address
	 */
	public function getAddress($facilityId, $doctorId, $addressId)
	{
		$request = $this->client->get([
			'facilities/{facilityId}/doctors/{doctorId}/addresses/{addressId}', [
				'facilityId' => $facilityId,
				'doctorId'   => $doctorId,
				'addressId'  => $addressId
			]
		]);

		return $this->authorizedRequest($request, Address::class);
	}

	/**
	 * @param int       $facilityId
	 * @param int       $doctorId
	 * @param int       $addressId
	 * @param \DateTime $start
	 * @param \DateTime $end
	 *
	 * @return SlotsResponse
	 */
	public function getSlots($facilityId, $doctorId, $addressId, $start, $end)
	{
		$request =
			$this->client->get([
				'facilities/{facilityId}/doctors/{doctorId}/addresses/{addressId}/slots{?start,end}', [
					'facilityId' => $facilityId,
					'doctorId'   => $doctorId,
					'addressId'  => $addressId,
					'start'      => $start->format('c'),
					'end'        => $end->format('c')
				]
			]);

		$slots = $this->authorizedRequest($request, SlotsResponse::class);

		return $slots;
	}

	/**
	 * @param int             $facilityId
	 * @param int             $doctorId
	 * @param int             $addressId
	 *
	 * @param PutSlotsRequest $putSlots
	 *
	 * @return PutSlotsResponse
	 */
	public function putSlots($facilityId, $doctorId, $addressId, $putSlots)
	{
		$requestBody = $this->serializer->serialize(
			$putSlots,
			'json',
			SerializationContext::create()->setGroups(['Default', 'put_slots'])
		);

		$request =
			$this->client->put([
				'facilities/{facilityId}/doctors/{doctorId}/addresses/{addressId}/slots', [
					'facilityId' => $facilityId,
					'doctorId'   => $doctorId,
					'addressId'  => $addressId
				]
			], null, $requestBody);

		$putSlotResponse = $this->authorizedRequest($request, PutSlotsResponse::class);

		return $putSlotResponse;
	}

	/**
	 * @param int              $facilityId
	 * @param int              $doctorId
	 * @param int              $addressId
	 * @param \DateTime        $start
	 * @param BookVisitRequest $bookVisitRequest
	 *
	 * @return BookVisitResponse
	 */
	public function bookSlot($facilityId, $doctorId, $addressId, $start, $bookVisitRequest)
	{
		$requestBody = $this->serializer->serialize($bookVisitRequest, 'json', SerializationContext::create()->setGroups(['Default', 'post_book']));

		$request =
			$this->client->post([
				'facilities/{facilityId}/doctors/{doctorId}/addresses/{addressId}/slots/{start}/book', [
					'facilityId' => $facilityId,
					'doctorId'   => $doctorId,
					'addressId'  => $addressId,
					'start'      => $start->format('c')
				]
			], null, $requestBody);

		return $this->authorizedRequest($request, BookVisitResponse::class);
	}

	/**
	 * @param int       $facilityId
	 * @param int       $doctorId
	 * @param int       $addressId
	 * @param \DateTime $date
	 *
	 * @return DeleteSlotsResponse
	 */
	public function deleteSlots($facilityId, $doctorId, $addressId, $date)
	{
		$request =
			$this->client->delete([
				'facilities/{facilityId}/doctors/{doctorId}/addresses/{addressId}/slots/{start}', [
					'facilityId' => $facilityId,
					'doctorId'   => $doctorId,
					'addressId'  => $addressId,
					'start'      => $date->format('Y-m-d')
				]
			]);

		$response = $this->authorizedRequest($request, DeleteSlotsResponse::class);

		return $response;
	}

	/**
	 * @param int       $facilityId
	 * @param int       $doctorId
	 * @param int       $addressId
	 * @param \DateTime $start
	 * @param \DateTime $end
	 *
	 * @return BookingsResponse
	 */
	public function getBookings($facilityId, $doctorId, $addressId, $start, $end)
	{
		$request = $this->client->get([
			'facilities/{facilityId}/doctors/{doctorId}/addresses/{addressId}/bookings{?start,end,with}', [
				'facilityId' => $facilityId,
				'doctorId'   => $doctorId,
				'addressId'  => $addressId,
				'start'      => $start->format('c'),
				'end'        => $end->format('c'),
				'with'       => ['booking.service', 'booking.patient']
			]
		]);

		$bookingList = $this->authorizedRequest($request, BookingsResponse::class, DeserializationContext::create()
			->setGroups(['Default', 'get']));

		return $bookingList;
	}

	/**
	 * @param int $facilityId
	 * @param int $doctorId
	 * @param int $addressId
	 * @param int $bookingId
	 *
	 * @return CancelVisitResponse
	 */
	public function cancelBooking($facilityId, $doctorId, $addressId, $bookingId)
	{
		$request = $this->client->delete([
			'facilities/{facilityId}/doctors/{doctorId}/addresses/{addressId}/bookings/{bookingId}', [
				'facilityId' => $facilityId,
				'doctorId'   => $doctorId,
				'addressId'  => $addressId,
				'bookingId'  => $bookingId
			]
		]);

		$response = $this->authorizedRequest($request, CancelVisitResponse::class);

		return $response;
	}

	/**
	 * @param int $facilityId
	 * @param int $doctorId
	 *
	 * @return DoctorServicesResponse
	 */
	public function getDoctorServices($facilityId, $doctorId)
	{
		/** @var DoctorServicesResponse $doctorServices */
		$request        = $this->client->get([
			'facilities/{facilityId}/doctors/{doctorId}/services', [
				'facilityId' => $facilityId,
				'doctorId'   => $doctorId
			]
		]);
		$doctorServices = $this->authorizedRequest(
			$request,
			DoctorServicesResponse::class,
			DeserializationContext::create()->setGroups(['Default', 'get'])
		);

		return $doctorServices;
	}

	/**
	 * @param int       $facilityId
	 * @param int       $doctorId
	 * @param int       $addressId
	 * @param \DateTime $start
	 *
	 * @return DoctorServicesResponse
	 */
	public function getDoctorServicesForSlot($facilityId, $doctorId, $addressId, $start)
	{
		/** @var DoctorServicesResponse $doctorServices */
		$request        = $this->client->get([
			'facilities/{facilityId}/doctors/{doctorId}/services{?address_id,start}', [
				'facilityId' => $facilityId,
				'doctorId'   => $doctorId,
				'address_id' => $addressId,
				'start'      => $start->format('c')
			]
		]);
		$doctorServices = $this->authorizedRequest(
			$request,
			DoctorServicesResponse::class,
			DeserializationContext::create()->setGroups(['Default', 'get'])
		);

		return $doctorServices;
	}

	/**
	 * @param int           $facilityId
	 * @param int           $doctorId
	 * @param DoctorService $doctorService
	 *
	 * @return DoctorService
	 */
	public function addDoctorService($facilityId, $doctorId, $doctorService)
	{

		$request = $this->client->post([
			'facilities/{facilityId}/doctors/{doctorId}/services', [
				'facilityId' => $facilityId,
				'doctorId'   => $doctorId
			]
		],
			null,
			$this->serializer->serialize($doctorService, 'json', SerializationContext::create()->setGroups(['post']))
		);

		/** @var DoctorService $newDoctorService */
		$newDoctorService = $this->authorizedRequest(
			$request,
			DoctorService::class,
			DeserializationContext::create()->setGroups(['get'])
		);


		return $newDoctorService;
	}

	/**
	 * @param int           $facilityId
	 * @param int           $doctorId
	 * @param DoctorService $doctorService
	 *
	 * @return DoctorService
	 */
	public function patchDoctorService($facilityId, $doctorId, $doctorService)
	{
		$request = $this->client->patch([
			'facilities/{facilityId}/doctors/{doctorId}/services/{doctorServiceId}', [
				'facilityId'      => $facilityId,
				'doctorId'        => $doctorId,
				'doctorServiceId' => $doctorService->getId()
			]
		],
			[],
			$this->serializer->serialize($doctorService, 'json', SerializationContext::create()->setGroups(['patch']))
		);


		/** @var DoctorService $newDoctorService */
		$newDoctorService = $this->authorizedRequest(
			$request,
			DoctorService::class,
			DeserializationContext::create()->setGroups(['get'])
		);


		return $newDoctorService;
	}

	/**
	 * @param $facilityId
	 * @param $doctorId
	 * @param $doctorServiceId
	 *
	 * @return DeleteDoctorServiceResponse
	 */
	public function deleteDoctorService($facilityId, $doctorId, $doctorServiceId)
	{
		$request = $this->client->delete([
			'facilities/{facilityId}/doctors/{doctorId}/services/{doctorServiceId}', [
				'facilityId'      => $facilityId,
				'doctorId'        => $doctorId,
				'doctorServiceId' => $doctorServiceId
			]
		]);

		$response = $this->authorizedRequest($request, DeleteDoctorServiceResponse::class);

		return $response;
	}

	/**
	 * @return ServicesResponse
	 */
	public function getServices()
	{
		/** @var ServicesResponse $services */
		$request  = $this->client->get('services');
		$services = $this->authorizedRequest($request, ServicesResponse::class);

		return $services;
	}


	/**
	 * @return string Notification content in JSON format
	 */
	public function getNotification()
	{
		$request  = $this->client->get('notifications');
		$response = $this->authorizedRequest($request)->getBody();

		return $response;
	}
}
