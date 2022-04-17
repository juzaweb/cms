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
 *      @OA\Response(response=201, ref="#/components/responses/success_detail"),
 *      @OA\Response(response=422, ref="#/components/responses/error_422"),
 *      @OA\Response(response=500, ref="#/components/responses/error_500")
 *  )
 */
