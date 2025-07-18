<?php
/**
 * WhiteLabelName SDK
 *
 * This library allows to interact with the WhiteLabelName payment service.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


namespace WhiteLabelMachineName\Sdk\Service;

use WhiteLabelMachineName\Sdk\ApiClient;
use WhiteLabelMachineName\Sdk\ApiException;
use WhiteLabelMachineName\Sdk\ApiResponse;
use WhiteLabelMachineName\Sdk\Http\HttpRequest;
use WhiteLabelMachineName\Sdk\ObjectSerializer;

/**
 * TokenService service
 *
 * @category Class
 * @package  WhiteLabelMachineName\Sdk
 * @author   WhiteLabelMachineName
 * @license  http://www.apache.org/licenses/LICENSE-2.0 Apache License v2
 */
class TokenService {

	/**
	 * The API client instance.
	 *
	 * @var ApiClient
	 */
	private $apiClient;

	/**
	 * Constructor.
	 *
	 * @param ApiClient $apiClient the api client
	 */
	public function __construct(ApiClient $apiClient) {
		if (is_null($apiClient)) {
			throw new \InvalidArgumentException('The api client is required.');
		}

		$this->apiClient = $apiClient;
	}

	/**
	 * Returns the API client instance.
	 *
	 * @return ApiClient
	 */
	public function getApiClient() {
		return $this->apiClient;
	}


	/**
	 * Operation checkTokenCreationPossible
	 *
	 * Check If Token Creation Is Possible
	 *
	 * @param int $space_id  (required)
	 * @param int $transaction_id The id of the transaction for which we want to check if the token can be created or not. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return bool
	 */
	public function checkTokenCreationPossible($space_id, $transaction_id) {
		return $this->checkTokenCreationPossibleWithHttpInfo($space_id, $transaction_id)->getData();
	}

	/**
	 * Operation checkTokenCreationPossibleWithHttpInfo
	 *
	 * Check If Token Creation Is Possible
     
     *
	 * @param int $space_id  (required)
	 * @param int $transaction_id The id of the transaction for which we want to check if the token can be created or not. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return ApiResponse
	 */
	public function checkTokenCreationPossibleWithHttpInfo($space_id, $transaction_id) {
		// verify the required parameter 'space_id' is set
		if (is_null($space_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $space_id when calling checkTokenCreationPossible');
		}
		// verify the required parameter 'transaction_id' is set
		if (is_null($transaction_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $transaction_id when calling checkTokenCreationPossible');
		}
		// header params
		$headerParams = [];
		$headerAccept = $this->apiClient->selectHeaderAccept([]);
		if (!is_null($headerAccept)) {
			$headerParams[HttpRequest::HEADER_KEY_ACCEPT] = $headerAccept;
		}
		$headerParams[HttpRequest::HEADER_KEY_CONTENT_TYPE] = $this->apiClient->selectHeaderContentType([]);

		// query params
		$queryParams = [];
		if (!is_null($space_id)) {
			$queryParams['spaceId'] = $this->apiClient->getSerializer()->toQueryValue($space_id);
		}
		if (!is_null($transaction_id)) {
			$queryParams['transactionId'] = $this->apiClient->getSerializer()->toQueryValue($transaction_id);
		}

		// path params
		$resourcePath = '/token/check-token-creation-possible';
		// default format to json
		$resourcePath = str_replace('{format}', 'json', $resourcePath);

		// form params
		$formParams = [];
		
		// for model (json/xml)
		$httpBody = '';
		if (isset($tempBody)) {
			$httpBody = $tempBody; // $tempBody is the method argument, if present
		} elseif (!empty($formParams)) {
			$httpBody = $formParams; // for HTTP post (form)
		}
		// make the API Call
		try {
			$response = $this->apiClient->callApi(
				$resourcePath,
				'POST',
				$queryParams,
				$httpBody,
				$headerParams,
				'bool',
				'/token/check-token-creation-possible'
            );
			return new ApiResponse($response->getStatusCode(), $response->getHeaders(), $this->apiClient->getSerializer()->deserialize($response->getData(), 'bool', $response->getHeaders()));
		} catch (ApiException $e) {
			switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        'bool',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 442:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ClientError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 542:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
			}
			throw $e;
		}
	}

	/**
	 * Operation count
	 *
	 * Count
	 *
	 * @param int $space_id  (required)
	 * @param \WhiteLabelMachineName\Sdk\Model\EntityQueryFilter $filter The filter which restricts the entities which are used to calculate the count. (optional)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return int
	 */
	public function count($space_id, $filter = null) {
		return $this->countWithHttpInfo($space_id, $filter)->getData();
	}

	/**
	 * Operation countWithHttpInfo
	 *
	 * Count
     
     *
	 * @param int $space_id  (required)
	 * @param \WhiteLabelMachineName\Sdk\Model\EntityQueryFilter $filter The filter which restricts the entities which are used to calculate the count. (optional)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return ApiResponse
	 */
	public function countWithHttpInfo($space_id, $filter = null) {
		// verify the required parameter 'space_id' is set
		if (is_null($space_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $space_id when calling count');
		}
		// header params
		$headerParams = [];
		$headerAccept = $this->apiClient->selectHeaderAccept(['application/json;charset=utf-8']);
		if (!is_null($headerAccept)) {
			$headerParams[HttpRequest::HEADER_KEY_ACCEPT] = $headerAccept;
		}
		$headerParams[HttpRequest::HEADER_KEY_CONTENT_TYPE] = $this->apiClient->selectHeaderContentType(['application/json;charset=utf-8']);

		// query params
		$queryParams = [];
		if (!is_null($space_id)) {
			$queryParams['spaceId'] = $this->apiClient->getSerializer()->toQueryValue($space_id);
		}

		// path params
		$resourcePath = '/token/count';
		// default format to json
		$resourcePath = str_replace('{format}', 'json', $resourcePath);

		// form params
		$formParams = [];
		// body params
		$tempBody = null;
		if (isset($filter)) {
			$tempBody = $filter;
		}

		// for model (json/xml)
		$httpBody = '';
		if (isset($tempBody)) {
			$httpBody = $tempBody; // $tempBody is the method argument, if present
		} elseif (!empty($formParams)) {
			$httpBody = $formParams; // for HTTP post (form)
		}
		// make the API Call
		try {
			$response = $this->apiClient->callApi(
				$resourcePath,
				'POST',
				$queryParams,
				$httpBody,
				$headerParams,
				'int',
				'/token/count'
            );
			return new ApiResponse($response->getStatusCode(), $response->getHeaders(), $this->apiClient->getSerializer()->deserialize($response->getData(), 'int', $response->getHeaders()));
		} catch (ApiException $e) {
			switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        'int',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 442:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ClientError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 542:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
			}
			throw $e;
		}
	}

	/**
	 * Operation create
	 *
	 * Create
	 *
	 * @param int $space_id  (required)
	 * @param \WhiteLabelMachineName\Sdk\Model\TokenCreate $entity The token object with the properties which should be created. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return \WhiteLabelMachineName\Sdk\Model\Token
	 */
	public function create($space_id, $entity) {
		return $this->createWithHttpInfo($space_id, $entity)->getData();
	}

	/**
	 * Operation createWithHttpInfo
	 *
	 * Create
     
     *
	 * @param int $space_id  (required)
	 * @param \WhiteLabelMachineName\Sdk\Model\TokenCreate $entity The token object with the properties which should be created. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return ApiResponse
	 */
	public function createWithHttpInfo($space_id, $entity) {
		// verify the required parameter 'space_id' is set
		if (is_null($space_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $space_id when calling create');
		}
		// verify the required parameter 'entity' is set
		if (is_null($entity)) {
			throw new \InvalidArgumentException('Missing the required parameter $entity when calling create');
		}
		// header params
		$headerParams = [];
		$headerAccept = $this->apiClient->selectHeaderAccept(['application/json;charset=utf-8']);
		if (!is_null($headerAccept)) {
			$headerParams[HttpRequest::HEADER_KEY_ACCEPT] = $headerAccept;
		}
		$headerParams[HttpRequest::HEADER_KEY_CONTENT_TYPE] = $this->apiClient->selectHeaderContentType(['application/json;charset=utf-8']);

		// query params
		$queryParams = [];
		if (!is_null($space_id)) {
			$queryParams['spaceId'] = $this->apiClient->getSerializer()->toQueryValue($space_id);
		}

		// path params
		$resourcePath = '/token/create';
		// default format to json
		$resourcePath = str_replace('{format}', 'json', $resourcePath);

		// form params
		$formParams = [];
		// body params
		$tempBody = null;
		if (isset($entity)) {
			$tempBody = $entity;
		}

		// for model (json/xml)
		$httpBody = '';
		if (isset($tempBody)) {
			$httpBody = $tempBody; // $tempBody is the method argument, if present
		} elseif (!empty($formParams)) {
			$httpBody = $formParams; // for HTTP post (form)
		}
		// make the API Call
		try {
			$response = $this->apiClient->callApi(
				$resourcePath,
				'POST',
				$queryParams,
				$httpBody,
				$headerParams,
				'\WhiteLabelMachineName\Sdk\Model\Token',
				'/token/create'
            );
			return new ApiResponse($response->getStatusCode(), $response->getHeaders(), $this->apiClient->getSerializer()->deserialize($response->getData(), '\WhiteLabelMachineName\Sdk\Model\Token', $response->getHeaders()));
		} catch (ApiException $e) {
			switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\Token',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 442:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ClientError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 542:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
			}
			throw $e;
		}
	}

	/**
	 * Operation createToken
	 *
	 * Create Token
	 *
	 * @param int $space_id  (required)
	 * @param int $transaction_id The id of the transaction for which we want to create the token. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return \WhiteLabelMachineName\Sdk\Model\Token
	 */
	public function createToken($space_id, $transaction_id) {
		return $this->createTokenWithHttpInfo($space_id, $transaction_id)->getData();
	}

	/**
	 * Operation createTokenWithHttpInfo
	 *
	 * Create Token
     
     *
	 * @param int $space_id  (required)
	 * @param int $transaction_id The id of the transaction for which we want to create the token. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return ApiResponse
	 */
	public function createTokenWithHttpInfo($space_id, $transaction_id) {
		// verify the required parameter 'space_id' is set
		if (is_null($space_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $space_id when calling createToken');
		}
		// verify the required parameter 'transaction_id' is set
		if (is_null($transaction_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $transaction_id when calling createToken');
		}
		// header params
		$headerParams = [];
		$headerAccept = $this->apiClient->selectHeaderAccept([]);
		if (!is_null($headerAccept)) {
			$headerParams[HttpRequest::HEADER_KEY_ACCEPT] = $headerAccept;
		}
		$headerParams[HttpRequest::HEADER_KEY_CONTENT_TYPE] = $this->apiClient->selectHeaderContentType([]);

		// query params
		$queryParams = [];
		if (!is_null($space_id)) {
			$queryParams['spaceId'] = $this->apiClient->getSerializer()->toQueryValue($space_id);
		}
		if (!is_null($transaction_id)) {
			$queryParams['transactionId'] = $this->apiClient->getSerializer()->toQueryValue($transaction_id);
		}

		// path params
		$resourcePath = '/token/create-token';
		// default format to json
		$resourcePath = str_replace('{format}', 'json', $resourcePath);

		// form params
		$formParams = [];
		
		// for model (json/xml)
		$httpBody = '';
		if (isset($tempBody)) {
			$httpBody = $tempBody; // $tempBody is the method argument, if present
		} elseif (!empty($formParams)) {
			$httpBody = $formParams; // for HTTP post (form)
		}
		// make the API Call
		try {
			$response = $this->apiClient->callApi(
				$resourcePath,
				'POST',
				$queryParams,
				$httpBody,
				$headerParams,
				'\WhiteLabelMachineName\Sdk\Model\Token',
				'/token/create-token'
            );
			return new ApiResponse($response->getStatusCode(), $response->getHeaders(), $this->apiClient->getSerializer()->deserialize($response->getData(), '\WhiteLabelMachineName\Sdk\Model\Token', $response->getHeaders()));
		} catch (ApiException $e) {
			switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\Token',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 442:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ClientError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 542:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
			}
			throw $e;
		}
	}

	/**
	 * Operation createTokenBasedOnTransaction
	 *
	 * Create Token Based On Transaction And Fill It With Stored Payment Information
	 *
	 * @param int $space_id  (required)
	 * @param int $transaction_id The id of the transaction for which we want to create the token. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return \WhiteLabelMachineName\Sdk\Model\TokenVersion
	 */
	public function createTokenBasedOnTransaction($space_id, $transaction_id) {
		return $this->createTokenBasedOnTransactionWithHttpInfo($space_id, $transaction_id)->getData();
	}

	/**
	 * Operation createTokenBasedOnTransactionWithHttpInfo
	 *
	 * Create Token Based On Transaction And Fill It With Stored Payment Information
     
     *
	 * @param int $space_id  (required)
	 * @param int $transaction_id The id of the transaction for which we want to create the token. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return ApiResponse
	 */
	public function createTokenBasedOnTransactionWithHttpInfo($space_id, $transaction_id) {
		// verify the required parameter 'space_id' is set
		if (is_null($space_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $space_id when calling createTokenBasedOnTransaction');
		}
		// verify the required parameter 'transaction_id' is set
		if (is_null($transaction_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $transaction_id when calling createTokenBasedOnTransaction');
		}
		// header params
		$headerParams = [];
		$headerAccept = $this->apiClient->selectHeaderAccept([]);
		if (!is_null($headerAccept)) {
			$headerParams[HttpRequest::HEADER_KEY_ACCEPT] = $headerAccept;
		}
		$headerParams[HttpRequest::HEADER_KEY_CONTENT_TYPE] = $this->apiClient->selectHeaderContentType([]);

		// query params
		$queryParams = [];
		if (!is_null($space_id)) {
			$queryParams['spaceId'] = $this->apiClient->getSerializer()->toQueryValue($space_id);
		}
		if (!is_null($transaction_id)) {
			$queryParams['transactionId'] = $this->apiClient->getSerializer()->toQueryValue($transaction_id);
		}

		// path params
		$resourcePath = '/token/create-token-based-on-transaction';
		// default format to json
		$resourcePath = str_replace('{format}', 'json', $resourcePath);

		// form params
		$formParams = [];
		
		// for model (json/xml)
		$httpBody = '';
		if (isset($tempBody)) {
			$httpBody = $tempBody; // $tempBody is the method argument, if present
		} elseif (!empty($formParams)) {
			$httpBody = $formParams; // for HTTP post (form)
		}
		// make the API Call
		try {
			$response = $this->apiClient->callApi(
				$resourcePath,
				'POST',
				$queryParams,
				$httpBody,
				$headerParams,
				'\WhiteLabelMachineName\Sdk\Model\TokenVersion',
				'/token/create-token-based-on-transaction'
            );
			return new ApiResponse($response->getStatusCode(), $response->getHeaders(), $this->apiClient->getSerializer()->deserialize($response->getData(), '\WhiteLabelMachineName\Sdk\Model\TokenVersion', $response->getHeaders()));
		} catch (ApiException $e) {
			switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\TokenVersion',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 442:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ClientError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 542:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
			}
			throw $e;
		}
	}

	/**
	 * Operation createTransactionForTokenUpdate
	 *
	 * Create Transaction for Token Update
	 *
	 * @param int $space_id  (required)
	 * @param int $token_id The id of the token which should be updated. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return \WhiteLabelMachineName\Sdk\Model\Transaction
	 */
	public function createTransactionForTokenUpdate($space_id, $token_id) {
		return $this->createTransactionForTokenUpdateWithHttpInfo($space_id, $token_id)->getData();
	}

	/**
	 * Operation createTransactionForTokenUpdateWithHttpInfo
	 *
	 * Create Transaction for Token Update
     
     *
	 * @param int $space_id  (required)
	 * @param int $token_id The id of the token which should be updated. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return ApiResponse
	 */
	public function createTransactionForTokenUpdateWithHttpInfo($space_id, $token_id) {
		// verify the required parameter 'space_id' is set
		if (is_null($space_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $space_id when calling createTransactionForTokenUpdate');
		}
		// verify the required parameter 'token_id' is set
		if (is_null($token_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $token_id when calling createTransactionForTokenUpdate');
		}
		// header params
		$headerParams = [];
		$headerAccept = $this->apiClient->selectHeaderAccept([]);
		if (!is_null($headerAccept)) {
			$headerParams[HttpRequest::HEADER_KEY_ACCEPT] = $headerAccept;
		}
		$headerParams[HttpRequest::HEADER_KEY_CONTENT_TYPE] = $this->apiClient->selectHeaderContentType([]);

		// query params
		$queryParams = [];
		if (!is_null($space_id)) {
			$queryParams['spaceId'] = $this->apiClient->getSerializer()->toQueryValue($space_id);
		}
		if (!is_null($token_id)) {
			$queryParams['tokenId'] = $this->apiClient->getSerializer()->toQueryValue($token_id);
		}

		// path params
		$resourcePath = '/token/createTransactionForTokenUpdate';
		// default format to json
		$resourcePath = str_replace('{format}', 'json', $resourcePath);

		// form params
		$formParams = [];
		
		// for model (json/xml)
		$httpBody = '';
		if (isset($tempBody)) {
			$httpBody = $tempBody; // $tempBody is the method argument, if present
		} elseif (!empty($formParams)) {
			$httpBody = $formParams; // for HTTP post (form)
		}
		// make the API Call
		try {
			$response = $this->apiClient->callApi(
				$resourcePath,
				'POST',
				$queryParams,
				$httpBody,
				$headerParams,
				'\WhiteLabelMachineName\Sdk\Model\Transaction',
				'/token/createTransactionForTokenUpdate'
            );
			return new ApiResponse($response->getStatusCode(), $response->getHeaders(), $this->apiClient->getSerializer()->deserialize($response->getData(), '\WhiteLabelMachineName\Sdk\Model\Transaction', $response->getHeaders()));
		} catch (ApiException $e) {
			switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\Transaction',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 442:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ClientError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 542:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
			}
			throw $e;
		}
	}

	/**
	 * Operation delete
	 *
	 * Delete
	 *
	 * @param int $space_id  (required)
	 * @param int $id  (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return void
	 */
	public function delete($space_id, $id) {
		return $this->deleteWithHttpInfo($space_id, $id)->getData();
	}

	/**
	 * Operation deleteWithHttpInfo
	 *
	 * Delete
     
     *
	 * @param int $space_id  (required)
	 * @param int $id  (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return ApiResponse
	 */
	public function deleteWithHttpInfo($space_id, $id) {
		// verify the required parameter 'space_id' is set
		if (is_null($space_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $space_id when calling delete');
		}
		// verify the required parameter 'id' is set
		if (is_null($id)) {
			throw new \InvalidArgumentException('Missing the required parameter $id when calling delete');
		}
		// header params
		$headerParams = [];
		$headerAccept = $this->apiClient->selectHeaderAccept(['application/json;charset=utf-8']);
		if (!is_null($headerAccept)) {
			$headerParams[HttpRequest::HEADER_KEY_ACCEPT] = $headerAccept;
		}
		$headerParams[HttpRequest::HEADER_KEY_CONTENT_TYPE] = $this->apiClient->selectHeaderContentType(['application/json;charset=utf-8']);

		// query params
		$queryParams = [];
		if (!is_null($space_id)) {
			$queryParams['spaceId'] = $this->apiClient->getSerializer()->toQueryValue($space_id);
		}

		// path params
		$resourcePath = '/token/delete';
		// default format to json
		$resourcePath = str_replace('{format}', 'json', $resourcePath);

		// form params
		$formParams = [];
		// body params
		$tempBody = null;
		if (isset($id)) {
			$tempBody = $id;
		}

		// for model (json/xml)
		$httpBody = '';
		if (isset($tempBody)) {
			$httpBody = $tempBody; // $tempBody is the method argument, if present
		} elseif (!empty($formParams)) {
			$httpBody = $formParams; // for HTTP post (form)
		}
		// make the API Call
		try {
			$response = $this->apiClient->callApi(
				$resourcePath,
				'POST',
				$queryParams,
				$httpBody,
				$headerParams,
				null,
				'/token/delete'
            );
			return new ApiResponse($response->getStatusCode(), $response->getHeaders());
		} catch (ApiException $e) {
			switch ($e->getCode()) {
                case 409:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ClientError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 442:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ClientError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 542:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
			}
			throw $e;
		}
	}

	/**
	 * Operation processTransaction
	 *
	 * Process Transaction
	 *
	 * @param int $space_id  (required)
	 * @param int $transaction_id The id of the transaction for which we want to check if the token can be created or not. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return \WhiteLabelMachineName\Sdk\Model\Charge
	 */
	public function processTransaction($space_id, $transaction_id) {
		return $this->processTransactionWithHttpInfo($space_id, $transaction_id)->getData();
	}

	/**
	 * Operation processTransactionWithHttpInfo
	 *
	 * Process Transaction
     
     *
	 * @param int $space_id  (required)
	 * @param int $transaction_id The id of the transaction for which we want to check if the token can be created or not. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return ApiResponse
	 */
	public function processTransactionWithHttpInfo($space_id, $transaction_id) {
		// verify the required parameter 'space_id' is set
		if (is_null($space_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $space_id when calling processTransaction');
		}
		// verify the required parameter 'transaction_id' is set
		if (is_null($transaction_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $transaction_id when calling processTransaction');
		}
		// header params
		$headerParams = [];
		$headerAccept = $this->apiClient->selectHeaderAccept([]);
		if (!is_null($headerAccept)) {
			$headerParams[HttpRequest::HEADER_KEY_ACCEPT] = $headerAccept;
		}
		$headerParams[HttpRequest::HEADER_KEY_CONTENT_TYPE] = $this->apiClient->selectHeaderContentType([]);

		// query params
		$queryParams = [];
		if (!is_null($space_id)) {
			$queryParams['spaceId'] = $this->apiClient->getSerializer()->toQueryValue($space_id);
		}
		if (!is_null($transaction_id)) {
			$queryParams['transactionId'] = $this->apiClient->getSerializer()->toQueryValue($transaction_id);
		}

		// path params
		$resourcePath = '/token/process-transaction';
		// default format to json
		$resourcePath = str_replace('{format}', 'json', $resourcePath);

		// form params
		$formParams = [];
		
		// for model (json/xml)
		$httpBody = '';
		if (isset($tempBody)) {
			$httpBody = $tempBody; // $tempBody is the method argument, if present
		} elseif (!empty($formParams)) {
			$httpBody = $formParams; // for HTTP post (form)
		}
		// make the API Call
		try {
			$response = $this->apiClient->callApi(
				$resourcePath,
				'POST',
				$queryParams,
				$httpBody,
				$headerParams,
				'\WhiteLabelMachineName\Sdk\Model\Charge',
				'/token/process-transaction'
            );
			return new ApiResponse($response->getStatusCode(), $response->getHeaders(), $this->apiClient->getSerializer()->deserialize($response->getData(), '\WhiteLabelMachineName\Sdk\Model\Charge', $response->getHeaders()));
		} catch (ApiException $e) {
			switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\Charge',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 442:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ClientError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 542:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
			}
			throw $e;
		}
	}

	/**
	 * Operation read
	 *
	 * Read
	 *
	 * @param int $space_id  (required)
	 * @param int $id The id of the token which should be returned. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return \WhiteLabelMachineName\Sdk\Model\Token
	 */
	public function read($space_id, $id) {
		return $this->readWithHttpInfo($space_id, $id)->getData();
	}

	/**
	 * Operation readWithHttpInfo
	 *
	 * Read
     
     *
	 * @param int $space_id  (required)
	 * @param int $id The id of the token which should be returned. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return ApiResponse
	 */
	public function readWithHttpInfo($space_id, $id) {
		// verify the required parameter 'space_id' is set
		if (is_null($space_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $space_id when calling read');
		}
		// verify the required parameter 'id' is set
		if (is_null($id)) {
			throw new \InvalidArgumentException('Missing the required parameter $id when calling read');
		}
		// header params
		$headerParams = [];
		$headerAccept = $this->apiClient->selectHeaderAccept(['application/json;charset=utf-8']);
		if (!is_null($headerAccept)) {
			$headerParams[HttpRequest::HEADER_KEY_ACCEPT] = $headerAccept;
		}
		$headerParams[HttpRequest::HEADER_KEY_CONTENT_TYPE] = $this->apiClient->selectHeaderContentType(['*/*']);

		// query params
		$queryParams = [];
		if (!is_null($space_id)) {
			$queryParams['spaceId'] = $this->apiClient->getSerializer()->toQueryValue($space_id);
		}
		if (!is_null($id)) {
			$queryParams['id'] = $this->apiClient->getSerializer()->toQueryValue($id);
		}

		// path params
		$resourcePath = '/token/read';
		// default format to json
		$resourcePath = str_replace('{format}', 'json', $resourcePath);

		// form params
		$formParams = [];
		
		// for model (json/xml)
		$httpBody = '';
		if (isset($tempBody)) {
			$httpBody = $tempBody; // $tempBody is the method argument, if present
		} elseif (!empty($formParams)) {
			$httpBody = $formParams; // for HTTP post (form)
		}
		// make the API Call
		try {
			$response = $this->apiClient->callApi(
				$resourcePath,
				'GET',
				$queryParams,
				$httpBody,
				$headerParams,
				'\WhiteLabelMachineName\Sdk\Model\Token',
				'/token/read'
            );
			return new ApiResponse($response->getStatusCode(), $response->getHeaders(), $this->apiClient->getSerializer()->deserialize($response->getData(), '\WhiteLabelMachineName\Sdk\Model\Token', $response->getHeaders()));
		} catch (ApiException $e) {
			switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\Token',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 442:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ClientError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 542:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
			}
			throw $e;
		}
	}

	/**
	 * Operation search
	 *
	 * Search
	 *
	 * @param int $space_id  (required)
	 * @param \WhiteLabelMachineName\Sdk\Model\EntityQuery $query The query restricts the tokens which are returned by the search. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return \WhiteLabelMachineName\Sdk\Model\Token[]
	 */
	public function search($space_id, $query) {
		return $this->searchWithHttpInfo($space_id, $query)->getData();
	}

	/**
	 * Operation searchWithHttpInfo
	 *
	 * Search
     
     *
	 * @param int $space_id  (required)
	 * @param \WhiteLabelMachineName\Sdk\Model\EntityQuery $query The query restricts the tokens which are returned by the search. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return ApiResponse
	 */
	public function searchWithHttpInfo($space_id, $query) {
		// verify the required parameter 'space_id' is set
		if (is_null($space_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $space_id when calling search');
		}
		// verify the required parameter 'query' is set
		if (is_null($query)) {
			throw new \InvalidArgumentException('Missing the required parameter $query when calling search');
		}
		// header params
		$headerParams = [];
		$headerAccept = $this->apiClient->selectHeaderAccept(['application/json;charset=utf-8']);
		if (!is_null($headerAccept)) {
			$headerParams[HttpRequest::HEADER_KEY_ACCEPT] = $headerAccept;
		}
		$headerParams[HttpRequest::HEADER_KEY_CONTENT_TYPE] = $this->apiClient->selectHeaderContentType(['application/json;charset=utf-8']);

		// query params
		$queryParams = [];
		if (!is_null($space_id)) {
			$queryParams['spaceId'] = $this->apiClient->getSerializer()->toQueryValue($space_id);
		}

		// path params
		$resourcePath = '/token/search';
		// default format to json
		$resourcePath = str_replace('{format}', 'json', $resourcePath);

		// form params
		$formParams = [];
		// body params
		$tempBody = null;
		if (isset($query)) {
			$tempBody = $query;
		}

		// for model (json/xml)
		$httpBody = '';
		if (isset($tempBody)) {
			$httpBody = $tempBody; // $tempBody is the method argument, if present
		} elseif (!empty($formParams)) {
			$httpBody = $formParams; // for HTTP post (form)
		}
		// make the API Call
		try {
			$response = $this->apiClient->callApi(
				$resourcePath,
				'POST',
				$queryParams,
				$httpBody,
				$headerParams,
				'\WhiteLabelMachineName\Sdk\Model\Token[]',
				'/token/search'
            );
			return new ApiResponse($response->getStatusCode(), $response->getHeaders(), $this->apiClient->getSerializer()->deserialize($response->getData(), '\WhiteLabelMachineName\Sdk\Model\Token[]', $response->getHeaders()));
		} catch (ApiException $e) {
			switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\Token[]',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 442:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ClientError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 542:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
			}
			throw $e;
		}
	}

	/**
	 * Operation update
	 *
	 * Update
	 *
	 * @param int $space_id  (required)
	 * @param \WhiteLabelMachineName\Sdk\Model\TokenUpdate $entity The object with all the properties which should be updated. The id and the version are required properties. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return \WhiteLabelMachineName\Sdk\Model\Token
	 */
	public function update($space_id, $entity) {
		return $this->updateWithHttpInfo($space_id, $entity)->getData();
	}

	/**
	 * Operation updateWithHttpInfo
	 *
	 * Update
     
     *
	 * @param int $space_id  (required)
	 * @param \WhiteLabelMachineName\Sdk\Model\TokenUpdate $entity The object with all the properties which should be updated. The id and the version are required properties. (required)
	 * @throws \WhiteLabelMachineName\Sdk\ApiException
	 * @throws \WhiteLabelMachineName\Sdk\VersioningException
	 * @throws \WhiteLabelMachineName\Sdk\Http\ConnectionException
	 * @return ApiResponse
	 */
	public function updateWithHttpInfo($space_id, $entity) {
		// verify the required parameter 'space_id' is set
		if (is_null($space_id)) {
			throw new \InvalidArgumentException('Missing the required parameter $space_id when calling update');
		}
		// verify the required parameter 'entity' is set
		if (is_null($entity)) {
			throw new \InvalidArgumentException('Missing the required parameter $entity when calling update');
		}
		// header params
		$headerParams = [];
		$headerAccept = $this->apiClient->selectHeaderAccept(['application/json;charset=utf-8']);
		if (!is_null($headerAccept)) {
			$headerParams[HttpRequest::HEADER_KEY_ACCEPT] = $headerAccept;
		}
		$headerParams[HttpRequest::HEADER_KEY_CONTENT_TYPE] = $this->apiClient->selectHeaderContentType(['application/json;charset=utf-8']);

		// query params
		$queryParams = [];
		if (!is_null($space_id)) {
			$queryParams['spaceId'] = $this->apiClient->getSerializer()->toQueryValue($space_id);
		}

		// path params
		$resourcePath = '/token/update';
		// default format to json
		$resourcePath = str_replace('{format}', 'json', $resourcePath);

		// form params
		$formParams = [];
		// body params
		$tempBody = null;
		if (isset($entity)) {
			$tempBody = $entity;
		}

		// for model (json/xml)
		$httpBody = '';
		if (isset($tempBody)) {
			$httpBody = $tempBody; // $tempBody is the method argument, if present
		} elseif (!empty($formParams)) {
			$httpBody = $formParams; // for HTTP post (form)
		}
		// make the API Call
		try {
			$response = $this->apiClient->callApi(
				$resourcePath,
				'POST',
				$queryParams,
				$httpBody,
				$headerParams,
				'\WhiteLabelMachineName\Sdk\Model\Token',
				'/token/update'
            );
			return new ApiResponse($response->getStatusCode(), $response->getHeaders(), $this->apiClient->getSerializer()->deserialize($response->getData(), '\WhiteLabelMachineName\Sdk\Model\Token', $response->getHeaders()));
		} catch (ApiException $e) {
			switch ($e->getCode()) {
                case 200:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\Token',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 409:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ClientError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 442:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ClientError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
                case 542:
                    $data = ObjectSerializer::deserialize(
                        $e->getResponseBody(),
                        '\WhiteLabelMachineName\Sdk\Model\ServerError',
                        $e->getResponseHeaders()
                    );
                    $e->setResponseObject($data);
                break;
			}
			throw $e;
		}
	}


}
