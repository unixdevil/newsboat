<?php

namespace Cornatul\News\Requests;

use Carbon\Carbon;
use Saloon\CachePlugin\Contracts\Cacheable;
use Saloon\CachePlugin\Traits\HasCaching;
use Saloon\Http\Request;

class AllNewsRequests extends Request implements Cacheable
{

    use HasCaching;

    protected Method $method = Method::GET;

    public function __construct(
        protected string $topic,
    ){}

    public function resolveEndpoint(): string
    {
        return '/everything';
    }

    protected function defaultQuery(): array
    {
        return [
            'q' => $this->topic,
            'sortBy' => 'publishedAt',
            'apiKey' => 'c29a123962034057aac547e7321be062',
            'language' => 'en',
            'from' => Carbon::now()->subDays(7)->format('Y-m-d'),
        ];
    }

    public function resolveCacheDriver(): Driver
    {
        return new LaravelCacheDriver(Cache::store('file'));
    }

    public function cacheExpiryInSeconds(): int
    {
        return 3600; // One Hour
    }

    protected function getCacheableMethods(): array
    {
        return [Method::GET];
    }
}