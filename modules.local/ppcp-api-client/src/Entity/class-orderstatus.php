<?php
/**
 * The OrderStatus object.
 *
 * @package Inpsyde\PayPalCommerce\ApiClient\Entity
 */

declare(strict_types=1);

namespace Inpsyde\PayPalCommerce\ApiClient\Entity;

use Inpsyde\PayPalCommerce\ApiClient\Exception\RuntimeException;

/**
 * Class OrderStatus
 */
class OrderStatus {


	public const INTERNAL    = 'INTERNAL';
	public const CREATED     = 'CREATED';
	public const SAVED       = 'SAVED';
	public const APPROVED    = 'APPROVED';
	public const VOIDED      = 'VOIDED';
	public const COMPLETED   = 'COMPLETED';
	public const VALID_STATI = array(
		self::INTERNAL,
		self::CREATED,
		self::SAVED,
		self::APPROVED,
		self::VOIDED,
		self::COMPLETED,
	);

	/**
	 * The status.
	 *
	 * @var string
	 */
	private $status;

	/**
	 * OrderStatus constructor.
	 *
	 * @param string $status The status.
	 * @throws RuntimeException When the status is not valid.
	 */
	public function __construct( string $status ) {
		if ( ! in_array( $status, self::VALID_STATI, true ) ) {
			throw new RuntimeException(
				sprintf(
					// translators: %s is the current status.
					__( '%s is not a valid status', 'woocommerce-paypal-commerce-gateway' ),
					$status
				)
			);
		}
		$this->status = $status;
	}

	/**
	 * Creates an OrderStatus "Internal"
	 *
	 * @return OrderStatus
	 */
	public static function as_internal(): OrderStatus {
		return new self( self::INTERNAL );
	}

	/**
	 * Compares the current status with a given one.
	 *
	 * @param string $status The status to compare with.
	 *
	 * @return bool
	 */
	public function is( string $status ): bool {
		return $this->status === $status;
	}

	/**
	 * Returns the status.
	 *
	 * @return string
	 */
	public function name(): string {
		return $this->status;
	}
}
