FROM node:20-alpine

WORKDIR /app

# Copia apenas o package.json para instalar dependências
COPY frontend/package*.json ./
RUN npm install

# Copia todo o frontend
COPY frontend/ ./

# Abre a porta usada pelo Vite (opcional)
EXPOSE 5173

CMD ["npm", "run", "dev", "--", "--host"]
