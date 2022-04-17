<?php

/**
 * @OA\Post(
 *      path="/api/auth/login",
 *      tags={"Auth"},
 *      summary="User login",
 *      operationId="api.auth.login",
 *      @OA\RequestBody(
 *          required=true,
 *          @OA\MediaType(
 *              mediaType="multipart/form-data",
 *              @OA\Schema(
 *                  required={"email","password"},
 *                  @OA\Property(property="email",
 *                      type="string",
 *                      example="string@gmail.com",
 *                      description="email"
 *                  ),
 *                  @OA\Property(property="password",
 *                      type="string",
 *                      example="string",
 *                      description="password"
 *                  )
 *              )
 *          )
 *      ),
 *      @OA\Response(
 *          response=200,
 *          description="Read success",
 *          @OA\JsonContent(
 *              @OA\Property(property="success", type="bool", example=true),
 *              @OA\Property(
 *                  property="data",
 *                  type="array",
 *                  @OA\Items( type="object" )
 *              ),
 *              @OA\Property( property="message", type="string", example=""),
 *          )
 *      ),
 *      @OA\Response(
 *          response=404,
 *          description="Not found",
 *          @OA\JsonContent(type="object")
 *      ),
 *      @OA\Response(response=500, description="Internal server error")
 *  )
 */
