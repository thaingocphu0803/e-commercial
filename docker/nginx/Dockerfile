# Use the official lightweight Nginx image as the base
FROM nginx:alpine

# Create a directory for Nginx log files
# The "-p" flag ensures no error if the directory already exists
RUN mkdir -p /var/log/nginx

# Create a directory to store the application source code
# The "-p" flag ensures the command succeeds even if the directory exists
RUN mkdir -p /var/www/html

# Copy the custom Nginx configuration file into the container
# This overrides the default configuration provided by the base image
COPY nginx.conf /etc/nginx/conf.d/default.conf