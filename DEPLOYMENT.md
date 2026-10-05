# Product Desk deployment

## Local setup

1. Copy `.env.example` to `.env` and fill in the Aiven MySQL connection values.
2. Create the schema with the migrations, or run the products SQL below.
3. Point Apache or Laragon at `public/` and open `/products`.

```sql
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Aiven MySQL

Use the Aiven service's host, port, database name, username, and password. Set `DB_SSL_CA` to the path of Aiven's CA certificate file; production MySQL connections require this certificate and verify it when the PDO driver supports verification. Never commit `.env` or credentials.

## React application and API

Run the backend from the LavaLust project root:

```powershell
php lava run 8001
```

In a second terminal, run the React app from `C:\laragon\www\mark-6`:

```powershell
npm install
npm run dev
```

Vite proxies `/api` to the local LavaLust server. The frontend uses `VITE_API_BASE_URL` when set; for a deployed frontend, set it to the backend URL followed by `/api` (for example, `https://your-api.onrender.com/api`).

The React application uses these authenticated endpoints:

| Method | Endpoint | Purpose |
| --- | --- | --- |
| POST | `/api/auth/login` | Log in with username/email and password |
| POST | `/api/auth/refresh` | Refresh an expired access token |
| POST | `/api/auth/logout` | Revoke the refresh token |
| GET | `/api/products` | List products |
| POST | `/api/products` | Create a product |
| PUT | `/api/products/{id}` | Update a product |
| DELETE | `/api/products/{id}` | Delete a product |

Run pending database migrations before using the API. Configure `JWT_SECRET`, `REFRESH_TOKEN_KEY`, and `ADMIN_EMAIL`/`ADMIN_PASSWORD` as environment variables. The two token secrets must be distinct, randomly generated values of at least 32 characters. `CORS_ALLOWED_ORIGIN` must contain the exact deployed frontend origin; for multiple origins, separate them with commas. A configured admin user is inserted on first API login when the `users` table is empty.

## Render

1. Push this repository to GitHub.
2. In Render, create a Blueprint and select the repository. Render will read `render.yaml` and build the supplied Docker image.
3. Set the database, token, admin, and CORS environment variables in the Render dashboard. Use Aiven's connection details, make the CA certificate available at the path configured in `DB_SSL_CA`, and set the exact deployed frontend origin.
4. Deploy, then run the migrations against Aiven using the repository's LavaLust migration command or apply the SQL directly.
5. Set the frontend's `VITE_API_BASE_URL` to the deployed backend URL followed by `/api`, then build and deploy the React app.
6. Test login, product listing, create, edit, delete, token refresh, and logout over HTTPS.

## GitHub commands

```bash
git add .
git commit -m "Add product CRUD"
git branch -M main
git remote add origin https://github.com/USER/REPOSITORY.git
git push -u origin main
```
