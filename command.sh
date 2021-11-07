#!/bin/bash

function show_help() {
    printf "

Usage:
$ ./command.sh COMMAND [COMMAND_ARGS...]

commands:
* build
* up
* down
* stop
* restart
* composer
* execute
* list_queues
"
}
function command_docker() {
    COMPOSE_DOCKER_CLI_BUILD=1 DOCKER_BUILDKIT=1 \
     docker-compose -f docker-compose.yml "$@"
}

function execute_container_command() {
    docker exec -it "$@"
}

case "$1" in
build)
    shift
    command_docker build "$@"
    ;;
up)
    shift
    command_docker up "$@"
    ;;
down)
    shift
    command_docker down "$@"
    ;;
stop)
    shift
    command_docker stop "$@"
    ;;
restart)
    shift
    command_docker restart "$@"
    ;;
composer)
    shift
    command_docker run --rm php-fpm composer "$@"
    ;;
execute)
    shift
    execute_container_command php-fpm-rabbitmq "$@"
    ;;
psql)
    shift
    execute_container_command postgres-server psql -U pgsql test "$@"
    ;;
*)
    show_help
esac