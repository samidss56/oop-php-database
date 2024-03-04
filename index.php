<?php

class Mahasiswa
{
    private $db;
    function __construct($db)
    {
        $this->db = $db;
    }

    function get_data()
    {

        $result = $this->db->query("SELECT * FROM data_diri");

        return $result->fetch_all();
    }

    function save_data($input)
    {
        $error = 0;

        if (!isset($input["nama"]) || $input["nama"] == "") {
            $error++;
        }

        if ($error > 0) {
            return array("success" => 0, "message" => "Ada kesalahan");
        } else {
            if ($this->db->query("INSERT INTO data_diri (nama, email, whatsapp, alamat) VALUES ('" . $input['nama'] . "', '" . $input['email'] . "', '" . $input['whatsapp'] . "', '" . $input['alamat'] . "')")) {
                return array("success" => 1, "message" => "Data tersimpan");
            } else {
                return array("success" => 0, "message" => "Database bermasalah");
            }
        }
    }
}

$mysqli = new mysqli("localhost", "root", "", "data_mahasiswa");

$data = new Mahasiswa($mysqli);

if (count($_POST) > 0) {
    $input = array();
    $input = $_POST;
    if ($data->save_data($input)) {

        echo '<script>alert("Sukses menambahkan data"); window.location="";</script>';
    } else {
        echo '<script>alert("Database bermasalah")</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OOP Database</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <h1 class="main-title">Registerasi Mahasiswa</h1>
    <div class="main-wrapper">
        <div class="data-wrapper">
            <h3 style="text-align:center">Data Mahasiswa</h3>
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Whatsapp</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data->get_data() as $row) { ?>
                        <tr>
                            <td><?php echo $row[1]; ?></td>
                            <td><?php echo $row[2]; ?></td>
                            <td><?php echo $row[3]; ?></td>
                            <td><?php echo $row[4]; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="form-wrapper">
            <h3 style="text-align:center">Input Data Diri</h3>
            <form action="" method="post">
                <label for="nama">Nama</label>
                <input type="text" name="nama" placeholder="Masukkan Nama Anda">
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="Masukkan Email Anda">
                <label for="whatsapp">Whatsapp</label>
                <input type="number" name="whatsapp" placeholder="Masukkan Nomor Whatsapp Anda">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" placeholder="Masukkan Alamat Anda"></textarea>
                <button type="submit">Simpan Data</button>
            </form>
        </div>
    </div>
</body>

</html>