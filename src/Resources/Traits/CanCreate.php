<?php

namespace Rackbeat\VismaConnect\Resources\Traits;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Rackbeat\VismaConnect\Models\Model;
use Rackbeat\VismaConnect\Resources\BaseResource;

/**
 * @mixin BaseResource
 */
trait CanCreate
{
	/**
	 * @param array|Model $data
	 *
	 * @return mixed
	 */
	public function create($data = [])
	{
		/** @var Response $response */
		$response = Http::vismaConnectApi()->post(
			$this->getStoreUrl(),
			$data instanceof Model ? $data->toArray() : $data
		);

		if ($response->failed()) {
			if (method_exists($this, 'failed')) {
				$this->failed($response);
			}

			throw new \Exception($response->body(), $response->status(), $response->toException()); // todo change class
		}

		$responseData = $response->json();

		if (method_exists($this, 'formatCreateResponse')) {
			return $this->formatCreateResponse($responseData);
		}

		$item = $responseData;

		if ($model = static::MODEL) {
			return new $model($item);
		}

		return $item;
	}

	public function getStoreUrl(): string
	{
		return $this->replaceInUrl($this->urlOverrides['store'] ?? $this->getIndexUrl());
	}

	public function setStoreUrl(string $url): self
	{
		$this->urlOverrides['store'] = $url;

		return $this;
	}
}