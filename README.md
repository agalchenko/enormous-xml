# ENORMOUS XML
Simple PHP7 Docker &amp; Compose Environment 

Command-line PHP script which will process XML file and filter out all users by age. 
The age range is specified as a script parameters.

### Technology included

* [PHP 7](http://php.net/)

### Requirements

* [Docker Native](https://www.docker.com/products/overview)

## Running

Clone the repository.
Change directory into the cloned project.
Run the following command.

```bash
$ docker-compose up -d
```

## Usage

Log in to the docker container php:

```bash
$ docker-compose exec php bash
```

If it is the first run application yo should install dependencies:

```bash
$ composer install
```

Run the command-line PHP script:

```bash
$ php [php-script] parse [path-to-source-xml] [age-from] [age-to]
```

You can find the result xml file with filtered users by age in the directory `'files/result/'`.

## Example

Input data (xml file `users.xml`):

```xml
<users>
    <user>
        <id>4</id>
        <name>User Four</name>
        <email>user4@mail.com</email>
        <age>33</age>
    </user>
    <user>
        <id>5</id>
        <name>User Five</name>
        <email>user5@mail.com</email>
        <age>45</age>
    </user>
    <user>
        <id>6</id>
        <name>User Six</name>
        <email>user6@mail.com</email>
        <age>26</age>
    </user>
</users>
```
Execute command:

```bash
php src/index.php -f parse files/source/users.xml 20 40
```

The option `-f` means that output result will be formatted in readable form.

Output result (xml file `users-20-40.xml`):

```xml
<users>
    <user>
        <id>4</id>
        <name>User Four</name>
        <email>user4@mail.com</email>
        <age>33</age>
    </user>
    <user>
        <id>6</id>
        <name>User Six</name>
        <email>user6@mail.com</email>
        <age>26</age>
    </user>
</users>
```