<?php
/**
 * The order object.
 *
 * @package Inpsyde\PayPalCommerce\ApiClient\Entity
 */

declare(strict_types=1);

namespace Inpsyde\PayPalCommerce\ApiClient\Entity;

/**
 * Class Order
 */
class Order {


	/**
	 * The ID.
	 *
	 * @var string
	 */
	private $id;

	/**
	 * The create time.
	 *
	 * @var \DateTime|null
	 */
	private $create_time;

	/**
	 * The purchase units.
	 *
	 * @var PurchaseUnit[]
	 */
	private $purchase_units;

	/**
	 * The payer.
	 *
	 * @var Payer|null
	 */
	private $payer;

	/**
	 * The order status.
	 *
	 * @var OrderStatus
	 */
	private $order_status;

	/**
	 * The intent.
	 *
	 * @var string
	 */
	private $intent;

	/**
	 * The update time.
	 *
	 * @var \DateTime|null
	 */
	private $update_time;

	/**
	 * The application context.
	 *
	 * @var ApplicationContext|null
	 */
	private $application_context;

	/**
	 * The payment source.
	 *
	 * @var PaymentSource|null
	 */
	private $payment_source;

	/**
	 * Order constructor.
	 *
	 * @see https://developer.paypal.com/docs/api/orders/v2/#orders-create-response
	 *
	 * @param string                  $id The ID.
	 * @param PurchaseUnit[]          $purchase_units The purchase units.
	 * @param OrderStatus             $order_status The order status.
	 * @param ApplicationContext|null $application_context The application context.
	 * @param PaymentSource|null      $payment_source The payment source.
	 * @param Payer|null              $payer The payer.
	 * @param string                  $intent The intent.
	 * @param \DateTime|null          $create_time The create time.
	 * @param \DateTime|null          $update_time The update time.
	 */
	public function __construct(
		string $id,
		array $purchase_units,
		OrderStatus $order_status,
		ApplicationContext $application_context = null,
		PaymentSource $payment_source = null,
		Payer $payer = null,
		string $intent = 'CAPTURE',
		\DateTime $create_time = null,
		\DateTime $update_time = null
	) {

		$this->id                  = $id;
		$this->application_context = $application_context;
		$this->purchase_units      = array_values(
			array_filter(
				$purchase_units,
				static function ( $unit ): bool {
					return is_a( $unit, PurchaseUnit::class );
				}
			)
		);
		$this->payer               = $payer;
		$this->order_status        = $order_status;
		$this->intent              = ( 'CAPTURE' === $intent ) ? 'CAPTURE' : 'AUTHORIZE';
		$this->purchase_units      = $purchase_units;
		$this->create_time         = $create_time;
		$this->update_time         = $update_time;
		$this->payment_source      = $payment_source;
	}

	/**
	 * Returns the ID.
	 *
	 * @return string
	 */
	public function id(): string {
		return $this->id;
	}

	/**
	 * Returns the create time.
	 *
	 * @return \DateTime|null
	 */
	public function create_time(): ?\DateTime {
		return $this->create_time;
	}

	/**
	 * Returns the update time.
	 *
	 * @return \DateTime|null
	 */
	public function udpate_time(): ?\DateTime {
		return $this->update_time;
	}

	/**
	 * Returns the intent.
	 *
	 * @return string
	 */
	public function intent(): string {
		return $this->intent;
	}

	/**
	 * Returns the payer.
	 *
	 * @return Payer|null
	 */
	public function payer(): ?Payer {
		return $this->payer;
	}

	/**
	 * Returns the purchase units.
	 *
	 * @return PurchaseUnit[]
	 */
	public function purchase_units(): array {
		return $this->purchase_units;
	}

	/**
	 * Returns the order status.
	 *
	 * @return OrderStatus
	 */
	public function status(): OrderStatus {
		return $this->order_status;
	}

	/**
	 * Returns the application context.
	 *
	 * @return ApplicationContext|null
	 */
	public function application_context(): ?ApplicationContext {

		return $this->application_context;
	}

	/**
	 * Returns the payment source.
	 *
	 * @return PaymentSource|null
	 */
	public function payment_source(): ?PaymentSource {

		return $this->payment_source;
	}

	/**
	 * Returns the object as array.
	 *
	 * @return array
	 */
	public function to_array(): array {
		$order = array(
			'id'             => $this->id(),
			'intent'         => $this->intent(),
			'status'         => $this->status()->name(),
			'purchase_units' => array_map(
				static function ( PurchaseUnit $unit ): array {
					return $unit->to_array();
				},
				$this->purchase_units()
			),
		);
		if ( $this->create_time() ) {
			$order['create_time'] = $this->create_time()->format( \DateTimeInterface::ISO8601 );
		}
		if ( $this->payer() ) {
			$order['payer'] = $this->payer()->to_array();
		}
		if ( $this->udpate_time() ) {
			$order['update_time'] = $this->udpate_time()->format( \DateTimeInterface::ISO8601 );
		}
		if ( $this->application_context() ) {
			$order['application_context'] = $this->application_context()->to_array();
		}
		if ( $this->payment_source() ) {
			$order['payment_source'] = $this->payment_source()->to_array();
		}

		return $order;
	}
}
