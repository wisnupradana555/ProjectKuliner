<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ProjectTables extends Migration
{
    public function up()
    {
        // --- 1. TABEL MASTER ---
        // Tabel Users
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama'       => ['type' => 'VARCHAR', 'constraint' => '255'],
            'email'      => ['type' => 'VARCHAR', 'constraint' => '255', 'unique' => true],
            'password'   => ['type' => 'VARCHAR', 'constraint' => '255'],
            'role'       => ['type' => 'ENUM', 'constraint' => ['admin', 'kontributor'], 'default' => 'kontributor'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('users');

        // Tabel Kategori
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_kategori' => ['type' => 'VARCHAR', 'constraint' => '100'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('kategori');

        // Tabel Tags
        $this->forge->addField([
            'id'       => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nama_tag' => ['type' => 'VARCHAR', 'constraint' => '100'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('tags');

        // --- 2. TABEL TRANSAKSI ---
        // Tabel Tempat Kuliner
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'kategori_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'nama'        => ['type' => 'VARCHAR', 'constraint' => '255'],
            'alamat'      => ['type' => 'TEXT'],
            'deskripsi'   => ['type' => 'TEXT', 'null' => true],
            'lat'         => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true],
            'lon'         => ['type' => 'VARCHAR', 'constraint' => '50', 'null' => true],
            'status'      => ['type' => 'ENUM', 'constraint' => ['pending', 'approved', 'rejected', 'tutup'], 'default' => 'pending'],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('kategori_id', 'kategori', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tempat_kuliner');

        // Tabel Foto Tempat
        $this->forge->addField([
            'id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'tempat_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'file_foto' => ['type' => 'VARCHAR', 'constraint' => '255'],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('tempat_id', 'tempat_kuliner', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('foto_tempat');

        // Tabel Reviews
        $this->forge->addField([
            'id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'tempat_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'user_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'rating'     => ['type' => 'INT', 'constraint' => 1],
            'komentar'   => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('tempat_id', 'tempat_kuliner', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('reviews');

        // --- 3. TABEL PIVOT ---
        // Tabel Tempat Tags
        $this->forge->addField([
            'tempat_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tag_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey(['tempat_id', 'tag_id']);
        $this->forge->addForeignKey('tempat_id', 'tempat_kuliner', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tag_id', 'tags', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tempat_tags');

        // Tabel Favorit
        $this->forge->addField([
            'user_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'tempat_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        ]);
        $this->forge->addKey(['user_id', 'tempat_id']);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('tempat_id', 'tempat_kuliner', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('favorit');
    }

    public function down()
    {
        // Urutan drop harus kebalikan dari urutan create agar rollback berfungsi
        $this->forge->dropTable('favorit');
        $this->forge->dropTable('tempat_tags');
        $this->forge->dropTable('reviews');
        $this->forge->dropTable('foto_tempat');
        $this->forge->dropTable('tempat_kuliner');
        $this->forge->dropTable('tags');
        $this->forge->dropTable('kategori');
        $this->forge->dropTable('users');
    }
}