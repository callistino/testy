Testy - a continuous test-runner
=====

**Testy** is a one-purpose tool - run tests and notify!

The dbus-notifier is based on the php dbus-extension (http://pecl.php.net/package/DBus) by Derick Rethans

Project-Configuration
-----

Example w/o File -> Test-Mapping
<pre>
"testy": {
    "path": "~/workspace/testy",
    "test": "phpunit", 
    "test_dir": "~/workspace/testy;",
    "syntax": "php -l $file",
    "find": "*.php"
}
</pre>

Example with File -> Test-Mapping
<pre>
"testy": {
    "path": "~/workspace/testy",
    "test": "phpunit $file {Testy|Tests} {.php|Test.php}", 
    "test_dir": "~/workspace/testy;",
    "syntax": "php -l $file",
    "find": "*.php"
}
</pre>

Options
-----

path:     The path that is checked for changed files
find:     The find-pattern that is used to find changed files
syntax:   Command to do a syntax-check (skips testing on error)
test_dir: The dir to cd in, before executing the test-command
test:     The test to execute on changed files
          support for placeholders:
          $file       Each file that changed
          $project    The projects name
          $time       The current timestmap
          $mtime      The modification's timestamp

repeat: Repeat the test-command without the specific file (which is replaced by ''), default: true 

File -> Test-Mapping
Use the {Search|Replace}-Pattern, as often as needed, to map the Source-File to it's test.
If all Search-Patterns are found within the changed-files path, it is assumed that this is a test file.