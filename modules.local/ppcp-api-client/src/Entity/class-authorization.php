<?php
/**
 * The Authorization object
 *
 * @package Inpsyde\PayPalCommerce\ApiClient\Entity
 */

declare(strict_types=1);

namespace Inpsyde\PayPalCommerce\ApiClient\Entity;

/**
 * Class Authorization
 */
class Authorization {

	/**
	 * The Id.
	 *
	 * @var string
	 */
	private $id;

	/**
	 * The status.
	 *
	 * @var AuthorizationStatus
	 */
	private $authorization_status;

	/**
	 * Authorization constructor.
	 *
	 * @param string              $id The id.
	 * @param AuthorizationStatus $authorization_status The status.
	 */
	public function __construct(
		string $id,
		AuthorizationStatus $authorization_status
	) {

		$this->id                   = $id;
		$this->authorization_status = $authorization_status;
	}

	/**
	 * Returns the Id.
	 *
	 * @return string
	 */
	public function id(): string {
		return $this->id;
	}

	/**
	 * Returns the status.
	 *
	 * @return AuthorizationStatus
	 */
	public function status(): AuthorizationStatus {
		return $this->authorization_status;
	}

	/**
	 * Returns the object as array.
	 *
	 * @return array
	 */
	public function to_array(): array {
		return array(
			'id'     => $this->id,
			'status' => $this->authorization_status->name(),
		);
	}
}
