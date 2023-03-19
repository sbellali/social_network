FROM node:latest as base
WORKDIR /usr/src/app
COPY package*.json ./
RUN npm install


FROM base as developement
CMD [ "npm", "run", "start:dev" ]


FROM base as production
CMD [ "node", "dist/main.js" ]
COPY . .
