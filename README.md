# Requirements

 - PHP 8.2
 - composer

# Install

Create .env file from example
```bash
$ cp .env.example .env
```

and add your tokens. Then update dependecies:

```bash
$ composer install
```

# Usage
 
 - Create `App\Task\TaskXX` class which implements `App\Task\TaskInterface`
- Update `config/services.yaml` by adding a mapping eg:

```yml
App\Config\TaskConfig:
        arguments:
            $taskMapping:
                'helloapi': '@App\Task\Task01'
```
- run Symfony command using name from mapping
```bash
$ php .\bin\console app:task helloapi
```

# Tips

To print output from task add data (strings or arrays) to `$this->logs[]`. `TaskCommand` will print it in console in human readable format.