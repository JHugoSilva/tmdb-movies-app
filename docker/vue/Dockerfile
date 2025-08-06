FROM node:20-alpine

WORKDIR /app

# Copia apenas o package.json para instalar dependências
COPY frontend/package*.json ./

# Copia todo o frontend
COPY frontend/ ./

CMD ["npm", "run", "dev", "--", "--host"]
