#!/bin/bash

# Define the port number
port="2525"

# Find the process ID (PID) listening on the specified port
pid=$(lsof -ti :$port)

# If a PID is found, kill the process
if [ -n "$pid" ]; then
    kill $pid
    echo "Process listening on port $port has been killed."
else
    echo "No process found listening on port $port."
fi
