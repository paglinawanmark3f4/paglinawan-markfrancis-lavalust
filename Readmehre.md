# Development and Debug Guide

Short reference for the LavaLust API + React/Vite frontend.

## Repositories and URLs

- Backend repo: `LAVALUST2-Mark` (`C:\laragon\www\`)
- Frontend repo: `not yet` (`C:\laragon\www\`)
- Backend: `https://paglinawan-markfrancis-lavalust-6.onrender.com`
- Frontend: `https://paglinawanmark-act-6.onrender.com`

Check before pushing from either repo:

```powershell
git status --short --branch
git remote -v
```

## Run locally

Terminal 1, backend project root:

```powershell
php lava run 8001
```

Terminal 2, frontend:

```powershell
cd C:\laragon\www\frontend
npm run dev
```

Local Vite uses `/backend/api` and proxies to the PHP server. Do not use that relative path in the deployed static site.

## Render settings

**Frontend Static Site**

- Build: `npm install && npm run build`
- Publish directory: `dist`
- Environment variable: `VITE_API_BASE_URL=https://paglinawan-markfrancis-lavalust-6.onrender.com`
- Save and redeploy after changing it; Vite embeds this value at build time.

**Backend Web Service**

- Deploy the `mason-lava` repository and intended branch.
- Set Aiven database variables, `APP_ENV=production`, `JWT_SECRET`, and `REFRESH_TOKEN_KEY` in Render.
- Keep secrets distinct, strong, and out of Git.
- In `app/config/api.php`, allow the exact frontend origin:

```php
$config['allow_origin'] = 'https://mason-frontend-6aay.onrender.com';
```

Redeploy the backend after changing its config or code.

## Debug checklist

1. Browser DevTools > Network > inspect the login request URL, status, response body, and response headers.
2. Expected URL: `https://paglinawan-markfrancis-lavalust-6.onrender.com/login`.
3. A `401` invalid-credentials JSON or `422` missing-fields JSON means the API route answered. A successful login includes `tokens.access_token`.
4. `Failed to fetch`: check the request URL, backend availability, CORS/preflight headers, and Render logs.
5. `Cannot read ... access_token`: inspect the response; it did not contain the expected `tokens` object.
6. `500`: inspect Render backend logs for PHP, database, or missing environment-variable errors.

## Push safely

From each repository separately, verify `git remote -v` and `git status` first. Stage only intended files; never add `.env`, `node_modules`, or `dist`. Then:

```powershell
git add <intended-files>
git commit -m "Describe the change"
git push origin main
```

## Reusable debugging prompt

```text
Debug this issue in my LavaLust PHP API + React/Vite app. First inspect the actual request URL, status, response body, and relevant local code/config; do not guess. Trace the failing path, state one testable root-cause hypothesis, make the smallest fix, and run a focused check. Distinguish local Vite proxy settings from Render build-time VITE_API_BASE_URL and backend CORS. Never reveal or commit secrets. Do not push unless I explicitly ask; verify the current repo remote and status first.
```
