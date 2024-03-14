FROM node:18

WORKDIR /usr/src/app

COPY ./operation-web/package*.json ./

RUN npm install

COPY ./operation-web .

EXPOSE 3000

ENTRYPOINT ["npm", "run", "dev"]