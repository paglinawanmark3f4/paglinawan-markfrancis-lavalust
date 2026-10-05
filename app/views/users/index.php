<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Inter',sans-serif;
        }

        body{
            background:#0d0d0d;
            color:#ffffff;
            min-height:100vh;
            padding:50px 20px;
        }

        .container{
            max-width:1200px;
            margin:auto;
        }

        .card{
            background:#141414;
            border:1px solid rgba(212,175,55,.25);
            border-radius:24px;
            overflow:hidden;
            box-shadow:
                0 10px 40px rgba(0,0,0,.5),
                0 0 30px rgba(212,175,55,.08);
        }

        .header{
            padding:40px;
            background:#111111;
            border-bottom:1px solid rgba(212,175,55,.15);
        }

        .header h1{
            font-size:2rem;
            font-weight:700;
            color:#d4af37;
            letter-spacing:1px;
            margin-bottom:8px;
        }

        .header p{
            color:#a1a1aa;
            font-size:.95rem;
        }

        .table-wrapper{
            overflow-x:auto;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        thead th{
            background:#1a1a1a;
            color:#d4af37;
            padding:18px 30px;
            text-align:left;
            font-size:.85rem;
            font-weight:600;
            text-transform:uppercase;
            letter-spacing:1px;
            border-bottom:1px solid rgba(212,175,55,.15);
        }

        tbody td{
            padding:22px 30px;
            color:#e5e5e5;
            border-bottom:1px solid rgba(255,255,255,.05);
        }

        tbody tr{
            transition:all .3s ease;
        }

        tbody tr:hover{
            background:#1c1c1c;
        }

        .user-id{
            color:#d4af37;
            font-weight:700;
        }

        .empty{
            text-align:center;
            padding:50px;
            color:#d4af37;
            font-size:1rem;
        }

        .footer{
            padding:20px;
            text-align:center;
            color:#9ca3af;
            background:#111111;
            border-top:1px solid rgba(212,175,55,.15);
            font-size:.85rem;
        }

        @media (max-width:768px){

            .header{
                padding:30px;
            }

            .header h1{
                font-size:1.6rem;
            }

            table{
                min-width:700px;
            }

        }
    </style>
</head>
<body>

<div class="container">

    <div class="card">

        <div class="header">
            <h1>User Management</h1>
            <p>Premium Administration Dashboard</p>
        </div>

        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Username</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (!empty($users)) : ?>

                    <?php foreach ($users as $user) : ?>

                    <tr>

                        <td class="user-id">
                            <?= htmlspecialchars($user['id'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($user['firstname'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($user['lastname'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($user['email'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($user['username'] ?? '') ?>
                        </td>

                    </tr>

                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>
                        <td colspan="5" class="empty">
                            No users found.
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

        <div class="footer">
            © <?= date('Y') ?> User Management System
        </div>

    </div>

</div>

</body>
</html>