# simple-cache
Simple PHP object caching base on temp file

[![Packagist](https://img.shields.io/packagist/v/jaredchu/simple-cache.svg)](https://packagist.org/packages/jaredchu/simple-cache)
[![Packagist](https://img.shields.io/packagist/dt/jaredchu/simple-cache.svg)](https://packagist.org/packages/jaredchu/simple-cache)
[![Travis](https://img.shields.io/travis/jaredchu/Simple-Cache.svg)](https://travis-ci.org/jaredchu/Simple-Cache)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/jaredchu/Simple-Cache.svg)](https://scrutinizer-ci.com/g/jaredchu/Simple-Cache/)
[![Codecov](https://img.shields.io/codecov/c/github/jaredchu/Simple-Cache.svg)](https://codecov.io/gh/jaredchu/simple-cache)
[![Packagist](https://img.shields.io/packagist/l/jaredchu/simple-cache.svg)](https://packagist.org/packages/jaredchu/simple-cache)
[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bhttps%3A%2F%2Fgithub.com%2Fjaredchu%2FSimple-Cache.svg?type=shield)](https://app.fossa.io/projects/git%2Bhttps%3A%2F%2Fgithub.com%2Fjaredchu%2FSimple-Cache?ref=badge_shield)

## Installation
`$ composer require jaredchu/simple-cache`

## Usage

#### Quick start
```PHP
use JC\Cache\SimpleCache;

// store your object
SimpleCache::add('your-key', new Person('Jared', 27));

// check if exists
SimpleCache::exists('your-key');

// fetch your object
$person = SimpleCache::fetch('your-key', Person::class);

// remove your cache
SimpleCache::remove('your-key');
```

#### Add
```PHP
// cache object Person with lifetime 1000 seconds (default is 0, not expire)
SimpleCache::add('your-key', new Person('Jared', 27), 1000);
```
#### Fetch
```PHP
if(SimpleCache::exists('your-key')){
  $person = SimpleCache::fetch('your-key', Person::class);
  $person->sayHi();
}
```
#### Remove
```PHP
SimpleCache::remove('your-key');
```
#### Security
```PHP
// your data is already encrypt but you can set your own encrypt key
SimpleCache::setEncryptKey('your unique string');
SimpleCache::add('your-key', new Person('Jared', 27));

// you must set encrypt key again if you want to call fetch in another session
SimpleCache::setEncryptKey('your unique string');
$person = SimpleCache::fetch('your-key', Person::class);
```

## Contributing
1. Fork it!
2. Create your feature branch: `$ git checkout -b feature/your-new-feature`
3. Commit your changes: `$ git commit -am 'Add some feature'`
4. Push to the branch: `$ git push origin feature/your-new-feature`
5. Submit a pull request.

## License
[MIT License](https://github.com/jaredchu/Simple-Cache/blob/master/LICENSE)


[![FOSSA Status](https://app.fossa.io/api/projects/git%2Bhttps%3A%2F%2Fgithub.com%2Fjaredchu%2FSimple-Cache.svg?type=large)](https://app.fossa.io/projects/git%2Bhttps%3A%2F%2Fgithub.com%2Fjaredchu%2FSimple-Cache?ref=badge_large)
