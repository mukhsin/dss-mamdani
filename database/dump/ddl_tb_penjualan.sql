CREATE TABLE tb_penjualan
(
	penjualan_id BIGINT UNSIGNED AUTO_INCREMENT
		PRIMARY KEY,
	produk_id    BIGINT UNSIGNED NOT NULL,
	tgl_pesanan  DATE            NOT NULL,
	harga_jual   DECIMAL(15, 2)  NOT NULL,
	qty          INT             NOT NULL,
	created_at   TIMESTAMP       NULL,
	updated_at   TIMESTAMP       NULL,
	CONSTRAINT tb_penjualan_produk_id_foreign
		FOREIGN KEY ( produk_id ) REFERENCES tb_produk ( produk_id )
)
	COLLATE = utf8mb4_unicode_ci;
