<?php 
header("content-type: application/vnd-ms-exel");
header("content-Disposition: attachment; filename=$title.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<h3><center>Laporan Data Anggota Perpustakaan Online</center></h3>
    <br/>
    <table class="table-data">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach($anggota as $b) {
            ?>
                <tr>
                    <th scope="row"><?= $no++; ?></th> <!-- Corrected 'scoope' to 'scope' -->
                    <td><?= $b['nama']; ?></td>
                    <td><?= $b['alamat']; ?></td>
                    <td><?= $b['email']; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
    