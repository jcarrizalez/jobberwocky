FROM node:14

LABEL maintainer="Juan Carrizalez <sitgem@gmail.com>"

# Set working directory
WORKDIR /app

COPY ./jobberwocky-extra-source/package*.json ./
RUN npm install --loglevel=error