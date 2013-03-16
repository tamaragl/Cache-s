
<?php

interface CacheInterface
{
	public function exists( $key );
	public function set( $key, $value, $ttl );
	public function get( $key );
	public function delete( $key );
	public function flush();
}


class MemcachedCache implements CacheInterface
{
	protected $memcached;

	public function __construct()
	{
		$this->memcached = new Memcached();
		$this->memcached->addServer( 'localhost', '11211' );
	}

	public function exists( $key )
	{
		$this->memcached->get( $key );
		return ( Memcached::RES_NOTFOUND !== $this->memcached->getResultCode() );
	}

	public function get( $key )
	{
		return $this->memcached->get( $key );
	}

	public function set( $key, $value, $ttl = 0 )
	{
		return $this->memcached->set( $key, $value, $ttl );
	}

	public function delete( $key )
	{
		return $this->memcached->delete( $key );
	}

	public function flush()
	{
		return $this->memcached->flush();
	}
}