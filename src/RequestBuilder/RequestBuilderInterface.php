<?php

/*
 * This file is part of the NavBundle.
 *
 * (c) Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace NavBundle\RequestBuilder;

/**
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
interface RequestBuilderInterface
{
    /**
     * Get the class name used for the request builder.
     *
     * @return string the class name
     */
    public function getClassName(): string;

    /**
     * Get a copy of the request builder.
     *
     * @return self Creates a clone of the current request builder
     */
    public function copy(): self;

    /**
     * Specifies one or more restrictions to the request result.
     * Replaces any previously specified restrictions, if any.
     *
     * @see https://docs.microsoft.com/en-us/previous-versions/dynamicsnav-2016/hh879066(v=nav.90)?redirectedfrom=MSDN
     *
     * <code>
     *     $em->createRequestBuilder(User::class)
     *        ->where('username', 'username');
     * </code>
     *
     * @param string $field     the restriction field
     * @param string $predicate the restriction predicate
     *
     * @return self the request builder
     */
    public function where($field, $predicate): self;

    /**
     * Adds one or more restrictions to the request results, forming a logical
     * conjunction with any previously specified restrictions.
     *
     * @see https://docs.microsoft.com/en-us/previous-versions/dynamicsnav-2016/hh879066(v=nav.90)?redirectedfrom=MSDN
     *
     * <code>
     *     $em->createRequestBuilder(User::class)
     *        ->where('username', 'username')
     *        ->andWhere('position', '>=1');
     * </code>
     *
     * @param string $field     the restriction field
     * @param string $predicate the request predicate
     *
     * @return self the request builder
     *
     * @see where()
     */
    public function andWhere($field, $predicate): self;

    /**
     * Sets the id of the last result read (the "bookmarkKey").
     *
     * <code>
     *     $em->createRequestBuilder(User::class)
     *        ->where('username', 'username')
     *        ->setBookmarkKey('id-of-last-result-read');
     * </code>
     *
     * @param string|null $bookmarkKey the id of the last result read
     *
     * @return self the request builder
     */
    public function setBookmarkKey($bookmarkKey): self;

    /**
     * Gets the id of the last result read (the "bookmarkKey").
     * Returns NULL if {@link setBookmarkKey} was not applied to this RequestBuilder.
     *
     * @return string|null the id of the last result read
     */
    public function getBookmarkKey(): ?string;

    /**
     * Sets the maximum number of results to retrieve (the "setSize").
     *
     * <code>
     *     $em->createRequestBuilder(User::class)
     *        ->where('username', 'username')
     *        ->setSize(10);
     * </code>
     *
     * @param int|null $size the maximum number of results to retrieve
     *
     * @return self the request builder
     */
    public function setSize($size): self;

    /**
     * Gets the maximum number of results the request object was set to retrieve (the "setSize").
     * Returns NULL if {@link setSize} was not applied to this RequestBuilder.
     *
     * @return int|null maximum number of results
     */
    public function getSize(): ?int;

    /**
     * Find an object by its identifier.
     *
     * <code>
     *     $em->createRequestBuilder(User::class)
     *        ->find(1);
     * </code>
     *
     * @param mixed $identifier the identifier
     *
     * @return object|null the request result
     */
    public function loadById($identifier): ?object;

    /**
     * Executes the request and returns the single result.
     *
     * <code>
     *     $em->createRequestBuilder(User::class)
     *        ->where('username', 'username')
     *        ->getOneOrNullResult();
     * </code>
     *
     * @param string|null $hydrator the hydrator to use
     *
     * @return object|null the request result
     */
    public function getOneOrNullResult(string $hydrator = null): ?object;

    /**
     * Executes the request and returns the result.
     *
     * <code>
     *     $em->createRequestBuilder(User::class)
     *        ->where('username', 'username')
     *        ->getResult();
     * </code>
     *
     * @param string|null $hydrator the hydrator to use
     *
     * @return mixed the request result
     */
    public function getResult(string $hydrator = null);

    /**
     * Executes the request and count the number of results.
     *
     * <code>
     *     $em->createRequestBuilder(User::class)
     *        ->where('username', 'username')
     *        ->count();
     * </code>
     *
     * @return int the request number of results
     */
    public function count(): int;
}
