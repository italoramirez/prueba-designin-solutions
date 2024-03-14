FROM node:18

ENV NUXT_HOST=0.0.0.0
ENV NUXT_PORT=3000

ARG url

# Changing Workdir
WORKDIR /usr/src/app

COPY ${url}/package.json .

#RUN npm i

EXPOSE 3000

ENTRYPOINT ["tail", "-f", "/dev/null"]

#CMD ['npm','run','dev']
