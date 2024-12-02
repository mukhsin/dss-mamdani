CREATE TABLE tb_produk
(
	produk_id    BIGINT UNSIGNED AUTO_INCREMENT
		PRIMARY KEY,
	nama_produk  VARCHAR(255)   NOT NULL,
	berat_produk INT            NOT NULL,
	harga_modal  DECIMAL(15, 2) NOT NULL,
	created_at   TIMESTAMP      NULL,
	updated_at   TIMESTAMP      NULL
)
	COLLATE = utf8mb4_unicode_ci;
