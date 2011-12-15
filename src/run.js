// Node.js script that runs a php file.
process.stdin.resume();
process.stdin.setEncoding('utf8');

process.stdin.on('data', function() {
    // Run forever.
});

// Arguments ?
var fileName  = process.argv[2],
    arguments = process.argv.slice(3); 

console.log('Starting ' + fileName + '(' + arguments + ')');

// Spawn process
var spawn   = require('child_process').spawn,
    sub     = spawn(fileName, arguments);

// Listen to process
sub.stdout.setEncoding('utf8');
sub.stdout.on('data', function(data) {
    
    process.stdout.write(data);
    
});

sub.stderr.on('data', function(data) {
    
    process.stderr.write(data);
    
});

// Wait for process exit
sub.on('exit', function(code) {
    console.log('Child process exited with code ' + code);
});

