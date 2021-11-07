FROM rabbitmq:3.6.11-management
COPY rabbitmq.config /etc/rabbitmq/
RUN chmod 777 /etc/rabbitmq/rabbitmq.config
WORKDIR /var/lib/rabbitmq/
RUN rabbitmq-plugins enable rabbitmq_management  --offline
RUN rabbitmq-plugins list