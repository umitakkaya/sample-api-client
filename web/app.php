<?php

use App\Initialize;
use DP\DPClient;
use DP\Model\BookVisitRequest;
use DP\Model\DoctorService;
use DP\Model\PutSlotsRequest;


require '../vendor/autoload.php';

$init = new Initialize;

$app        = $init->getApp();
$serializer = $init->getSerializer();

$locale = $app->getCookie('locale');
$token  = $app->getCookie('token');
$dp     = (new DPClient($serializer, $locale))->setToken($token);


$app->get('/', function () use ($app, $dp)
{
	$app->render('index', [
		'token' => $app->getCookie('token')
	]);
});

$app->post('/authorization', function () use ($app, $dp)
{
	$clientId     = $app->request()->post('client-id');
	$clientSecret = $app->request()->post('client-secret');
	$locale       = $app->request()->post('locale');

	$dp->setClientId($clientId)->setClientSecret($clientSecret);
	$token = $dp->authorize();

	$app->setCookie('locale', $locale);
	$app->setCookie('token', $token);
	$app->setEncryptedCookie('clientId', $clientId);
	$app->setEncryptedCookie('clientSecret', $clientSecret);

	$app->response()->header('Content-Type', 'application/json');
	$app->response()->body(json_encode([
		'token'  => $token,
		'status' => true
	]));
});


$app->get('/forms/add-doctor-service', function () use ($app, $dp)
{

	$facilityId = $app->request()->get('facility-id');
	$doctorId   = $app->request()->get('doctor-id');
	$doctor     = $dp->getDoctor($facilityId, $doctorId);
	$services   = $dp->getServices();

	$app->check($doctor);
	$app->check($services);

	$app->render('partials.forms.add-doctor-service', [
		'services'   => $services->getItems(),
		'facilityId' => $facilityId,
		'doctor'     => $doctor
	]);
});


$app->get('/forms/modify-doctor-service', function () use ($app, $dp)
{


	$facilityId      = $app->request()->get('facility-id');
	$doctorId        = $app->request()->get('doctor-id');
	$doctorServiceId = $app->request()->get('doctor-service-id');


	$app->render('partials.forms.modify-doctor-service', [
		'facilityId'      => $facilityId,
		'doctorId'        => $doctorId,
		'doctorServiceId' => $doctorServiceId
	]);
});

$app->get('/forms/calendar', function () use ($app, $dp)
{
	$facilityId = $app->request()->get('facility-id');
	$doctorId   = $app->request()->get('doctor-id');

	$addresses = $dp->getAddresses($facilityId, $doctorId);
	$doctor    = $dp->getDoctor($facilityId, $doctorId);

	$app->check($addresses);
	$app->check($doctor);

	$app->render('partials.forms.calendar', [
		'addresses'  => $addresses->getItems(),
		'doctor'     => $doctor,
		'facilityId' => $facilityId,
		'minDate'    => (new DateTime('00:00:00'))->format('c'),
		'maxDate'    => (new DateTime('00:00:00'))->modify('+12 weeks')->format('c')
	]);
});

$app->get('/forms/book-visit', function () use ($app, $dp)
{
	$facilityId = $app->request()->get('facility-id');
	$doctorId   = $app->request()->get('doctor-id');
	$addressId  = $app->request()->get('address-id');
	$start      = new \DateTime($app->request()->get('start'));

	$address        = $dp->getAddress($facilityId, $doctorId, $addressId);
	$doctor         = $dp->getDoctor($facilityId, $doctorId);
	$doctorServices = $dp->getDoctorServicesForSlot($facilityId, $doctorId, $addressId, $start);

	$app->check($doctorServices);
	$app->check($address);
	$app->check($doctor);

	$app->render('partials.forms.book-visit', [
		'address'        => $address,
		'doctor'         => $doctor,
		'facilityId'     => $facilityId,
		'visitStart'     => $start,
		'extraFields'    => $address->getBookingExtraFields(),
		'doctorServices' => $doctorServices->getItems()
	]);
});


$app->get('/forms/put-slots', function () use ($app, $dp)
{

	$facilityId = $app->request()->get('facility-id');
	$doctorId   = $app->request()->get('doctor-id');
	$addressId  = $app->request()->get('address-id');

	$address        = $dp->getAddress($facilityId, $doctorId, $addressId);
	$doctor         = $dp->getDoctor($facilityId, $doctorId);
	$doctorServices = $dp->getDoctorServices($facilityId, $doctorId);

	$app->check($address);
	$app->check($doctor);
	$app->check($doctorServices);

	$app->render('partials.forms.put-slots', [
		'address'        => $address,
		'doctor'         => $doctor,
		'start'          => (new \DateTime)->modify('+1 day'),
		'end'            => (new \DateTime)->modify('+12 weeks'),
		'facilityId'     => $facilityId,
		'doctorServices' => $doctorServices->getItems()
	]);
});

$app->get('/inputs/slot', function () use ($app, $dp)
{

	$index      = $app->request()->get('index') ?: 0;
	$facilityId = $app->request()->get('facility-id');
	$doctorId   = $app->request()->get('doctor-id');

	$doctorServices = $dp->getDoctorServices($facilityId, $doctorId);

	$app->check($doctorServices);

	$app->render('partials.forms.inputs.slot', [
		'index'          => $index,
		'start'          => (new \DateTime)->modify('+1 day'),
		'facilityId'     => $facilityId,
		'doctorId'       => $doctorId,
		'doctorServices' => $doctorServices->getItems()
	]);
});

$app->get('/inputs/slot-doctor-service', function () use ($app, $dp)
{
	$slotIndex          = $app->request()->get('slot-index') ?: 0;
	$doctorServiceIndex = $app->request()->get('doctor-service-index') ?: 0;


	$facilityId = $app->request()->get('facility-id');
	$doctorId   = $app->request()->get('doctor-id');

	$doctorServices = $dp->getDoctorServices($facilityId, $doctorId);

	$app->check($doctorServices);

	$app->render('partials.forms.inputs.slot-doctor-service', [
		'slotIndex'          => $slotIndex,
		'doctorServiceIndex' => $doctorServiceIndex,
		'doctorServices'     => $doctorServices->getItems()
	]);
});


$app->get('/services', function () use ($app, $dp)
{
	$services = $dp->getServices();

	$app->check($services);

	$app->render('partials.services', [
		'services' => $services->getItems()
	]);
});

$app->get('/notifications', function () use ($app, $dp)
{
	$notification = $dp->getNotification();

	$app->render('partials.notification', [
		'notification' => json_encode(json_decode($notification), JSON_PRETTY_PRINT)
	]);
});


$app->get('/facilities', function () use ($app, $dp)
{
	$facilities = $dp->getFacilities();

	$app->check($facilities);

	$app->render('partials.facilities', [
		'facilities' => $facilities->getItems()
	]);
});


$app->get('/facilities/:facilityId', function ($facilityId) use ($app, $dp)
{
	$facility = $dp->getFacility($facilityId);

	$app->check($facility);

	$app->render('partials.facility', [
		'facility' => $facility
	]);
});

$app->get('/facilities/:facilityId/doctors', function ($facilityId) use ($app, $dp)
{
	$doctors = $dp->getDoctors($facilityId);

	$app->check($doctors);

	$app->render('partials.doctors', [
		'facilityId' => $facilityId,
		'doctors'    => $doctors->getItems()
	]);
});


$app->get('/facilities/:facilityId/doctors/:doctorId/addresses', function ($facilityId, $doctorId) use ($app, $dp)
{
	$addresses = $dp->getAddresses($facilityId, $doctorId);

	$app->check($addresses);

	$app->render('partials.modals.addresses', [
		'addresses'  => $addresses->getItems(),
		'facilityId' => $facilityId,
		'doctorId'   => $doctorId
	]);
});

$app->get('/facilities/:facilityId/doctors/:doctorId/slots', function ($facilityId, $doctorId) use ($app, $dp)
{
	$addressId = $app->request()->get('address-id');
	$start     = new \DateTime($app->request()->get('start'));
	$end       = new \DateTime($app->request()->get('end'));

	$slots = $dp->getSlots($facilityId, $doctorId, $addressId, $start, $end);

	$app->check($slots);

	$slots = $slots->getItems();

	$interval   = new DateInterval('P1D');
	$rangeStart = clone $start->modify('this week Monday')->setTime(0, 0, 0);
	$rangeEnd   = clone $end->modify('this week Sunday')->setTime(0, 0, 0)->add($interval);

	$range = new DatePeriod(
		$rangeStart,
		$interval,
		$rangeEnd
	);

	$slotList = [];

	/** @var \DateTime $date */
	foreach ($range as $date)
	{
		$ymd            = $date->format('Y-m-d');
		$slotList[$ymd] = [];
	}


	/** @var string */
	foreach ($slots as $slot)
	{
		$ymd              = $slot->getStart()->format('Y-m-d');
		$slotList[$ymd][] = $slot->getStart();
	}

	$app->render('partials.modals.slots', [
		'slotChunks' => array_chunk($slotList, 7, true),
		'facilityId' => $facilityId,
		'doctorId'   => $doctorId,
		'addressId'  => $addressId
	]);
});

$app->put(
	'/facilities/:facilityId/doctors/:doctorId/addresses/:addressId/slots',
	function ($facilityId, $doctorId, $addressId) use ($app, $dp, $serializer)
	{
		$data = $app->request()->post();

		/** @var PutSlotsRequest $putSlotsRequest */
		$putSlotsRequest = $serializer->deserialize(json_encode($data), PutSlotsRequest::class, 'json');

		$response = $dp->putSlots($facilityId, $doctorId, $addressId, $putSlotsRequest);

		$app->check($response);

		$app->response()->header('Content-Type', 'application/json');
		$app->response()->setBody(json_encode([
			'status' => true,
		]));
	}
);

$app->delete(
	'/facilities/:facilityId/doctors/:doctorId/addresses/:addressId/slots/:date',
	function ($facilityId, $doctorId, $addressId, $date) use ($app, $dp)
	{
		$date = new \DateTime($date);

		$result = $dp->deleteSlots($facilityId, $doctorId, $addressId, $date);

		$app->check($result);

		$app->response()->header('Content-Type', 'application/json');
		$app->response()->setBody(json_encode(['status' => true]));
	}
);

$app->post(
	'/facilities/:facilityId/doctors/:doctorId/addresses/:addressId/slots/:start/book',
	function ($facilityId, $doctorId, $addressId, $start) use ($app, $dp, $serializer)
	{
		$start = new \DateTime($start);
		$data  = $app->request()->post();

		//Let's avoid serializer DateTime format validation with a simple trick
		$data['patient']['birth_date'] = (new \DateTime($data['patient']['birth_date']))->format(DATETIME::ATOM);

		/** @var BookVisitRequest $bookVisitRequest */
		$bookVisitRequest = $serializer->deserialize(json_encode($data), BookVisitRequest::class, 'json');

		/**
		 * You may want to put some validation logic here.
		 */

		$bookVisitResponse = $dp->bookSlot($facilityId, $doctorId, $addressId, $start, $bookVisitRequest);

		$app->check($bookVisitResponse);

		$app->response()->header('Content-Type', 'application/json');
		$app->response()->setBody(json_encode([
			'status'     => true,
			'booking-id' => $bookVisitResponse->getId()
		]));
	}
);

$app->get('/facilities/:facilityId/doctors/:doctorId/addresses/:addressId/bookings',
	function ($facilityId, $doctorId, $addressId) use ($app, $dp)
	{
		$start = new \DateTime($app->request()->get('start'));
		$end   = new \DateTime($app->request()->get('end') ?: '+12 weeks');


		$bookings = $dp->getBookings($facilityId, $doctorId, $addressId, $start, $end);

		$app->check($bookings);

		$app->render('partials.modals.bookings', [
			'facilityId' => $facilityId,
			'doctorId'   => $doctorId,
			'addressId'  => $addressId,
			'bookings'   => $bookings->getItems(),
			'start'      => $start->format('c'),
			'end'        => $end->format('c')
		]);
	}
);

$app->get('/facilities/:facilityId/doctors/:doctorId/addresses/:addressId/booking-list',
	function ($facilityId, $doctorId, $addressId) use ($app, $dp)
	{
		$start = new \DateTime($app->request()->get('start'));
		$end   = new \DateTime($app->request()->get('end') ?: '+12 weeks');

		$bookings = $dp->getBookings($facilityId, $doctorId, $addressId, $start, $end);

		$app->check($bookings);

		$app->render('partials.booking-list', [
			'facilityId' => $facilityId,
			'doctorId'   => $doctorId,
			'addressId'  => $addressId,
			'bookings'   => $bookings->getItems()
		]);
	}
);

$app->delete('/facilities/:facilityId/doctors/:doctorId/addresses/:addressId/bookings/:bookingId',
	function ($facilityId, $doctorId, $addressId, $bookingId) use ($app, $dp)
	{
		$result = $dp->cancelBooking($facilityId, $doctorId, $addressId, $bookingId);

		$app->check($result);

		$app->response()->header('Content-Type', 'application/json');
		$app->response()->setBody(json_encode(['status' => $result]));
	}
);

$app->get('/facilities/:facilityId/doctors/:doctorId/services',
	function ($facilityId, $doctorId) use ($app, $dp)
	{
		$doctorServices = $dp->getDoctorServices($facilityId, $doctorId);

		$app->check($doctorServices);

		$app->render('partials.modals.doctor-services', [
			'facilityId'     => $facilityId,
			'doctorId'       => $doctorId,
			'doctorServices' => $doctorServices->getItems()
		]);
	}
);

$app->post(
	'/facilities/:facilityId/doctors/:doctorId/services',
	function ($facilityId, $doctorId) use ($app, $dp)
	{
		$serviceId = $app->request()->post('service-id');
		$priceMin  = $app->request()->post('minimum-price');
		$priceMax  = $app->request()->post('maximum-price');

		$doctorService = (new DoctorService)
			->setServiceId($serviceId)
			->setPriceMin($priceMin)
			->setPriceMax($priceMax);

		$newDoctorService = $dp->addDoctorService($facilityId, $doctorId, $doctorService);

		$app->check($newDoctorService);

		$response = [
			'status'            => true,
			'doctor-service-id' => $newDoctorService->getId()
		];

		$app->response()->header('Content-Type', 'application/json');
		$app->response()->body(json_encode($response));

	}
);

$app->patch(
	'/facilities/:facilityId/doctors/:doctorId/services/:doctorServiceId',
	function ($facilityId, $doctorId, $doctorServiceId) use ($app, $dp)
	{
		$priceMin = $app->request()->patch('minimum-price');
		$priceMax = $app->request()->patch('maximum-price');

		$doctorService = (new DoctorService)
			->setId($doctorServiceId)
			->setPriceMin($priceMin)
			->setPriceMax($priceMax);


		$patchedDoctorService = $dp->patchDoctorService($facilityId, $doctorId, $doctorService);

		$app->check($patchedDoctorService);

		$response = [
			'status'            => true,
			'doctor-service-id' => $patchedDoctorService->getId(),
			'min-price'         => $patchedDoctorService->getPriceMin(),
			'max-price'         => $patchedDoctorService->getPriceMax()
		];

		$app->response()->header('Content-Type', 'application/json');
		$app->response()->body(json_encode($response));
	}
);

$app->delete(
	'/facilities/:facilityId/doctors/:doctorId/services/:doctorServiceId',
	function ($facilityId, $doctorId, $doctorServiceId) use ($app, $dp)
	{
		$result = $dp->deleteDoctorService($facilityId, $doctorId, $doctorServiceId);

		$app->check($result);

		$app->response()->status(204);
	}
);

$app->error(function (\Exception $e) use ($app)
{
	$app->response()->status($e->getCode());
	$app->response()->header('Content-Type', 'application/json');
	$app->response()->setBody(
		json_encode([
				'status'  => false,
				'message' => $e->getMessage()
			]
		)
	);
});

$app->run();
