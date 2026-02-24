FROM coreharbor-new.idbmobile.tools/proxy_dockerhub/library/php:apache
COPY ./ /var/www/html/

RUN rm -rf /var/www/html/.git
RUN rm -rf /var/www/html/.gitignore
RUN rm -rf /var/www/html/deployment.yaml
RUN rm -rf /var/www/html/Dockerfile
RUN rm -rf /var/www/html/README.md
RUN rm -rf /var/www/html/workflow.yaml
