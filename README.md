# simple-cache
Simple PHP object caching base on temp file

[![Packagist](https://img.shields.io/packagist/v/jaredchu/simple-cache.svg)](https://packagist.org/packages/jaredchu/simple-cache)
[![Packagist](https://img.shields.io/packagist/dt/jaredchu/simple-cache.svg)](https://packagist.org/packages/jaredchu/simple-cache)
[![Travis](https://img.shields.io/travis/jaredchu/Simple-Cache.svg)](https://travis-ci.org/jaredchu/Simple-Cache)
[![Scrutinizer](https://img.shields.io/scrutinizer/g/jaredchu/Simple-Cache.svg)](https://scrutinizer-ci.com/g/jaredchu/Simple-Cache/)
[![Codecov](https://img.shields.io/codecov/c/github/jaredchu/Simple-Cache.svg)](https://codecov.io/gh/jaredchu/simple-cache)
[![Packagist](https://img.shields.io/packagist/l/jaredchu/simple-cache.svg)](https://packagist.org/packages/jaredchu/simple-cache)

## Installation
`$ composer require jaredchu/simple-cache`

## Usage

#### Add
```PHP
// cache object Person with lifetime 1000 seconds (default is 0, not expire)
SimpleCache::add('your-key', new Person('Jared', 27),1000);

// cache object Person and encrypt the data
EncryptCache::setEncryptKey('secret');
EncryptCache::add('your-key', new Person('Jared', 27));
```
#### Fetch
```PHP
if(SimpleCache::exists('your-key')){
  $person = SimpleCache::fetch('your-key', Person::class);
  $person->sayHi();
}

// fetch data from enscrypt cache
EncryptCache::setEncryptKey('secret');
if(EncryptCache::exists('your-key')){
  $person = EncryptCache::fetch('your-key', Person::class);
  $person->sayHi();
}
```
#### Remove
```PHP
SimpleCache::remove('your-key')
```

## Contributing
1. Fork it!
2. Create your feature branch: `$ git checkout -b feature/your-new-feature`
3. Commit your changes: `$ git commit -am 'Add some feature'`
4. Push to the branch: `$ git push origin feature/your-new-feature`
5. Submit a pull request.

## License
[MIT License](https://github.com/jaredchu/Simple-Cache/blob/master/LICENSE)
