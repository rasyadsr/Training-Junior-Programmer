
## Tugas SQL week 1

<details><summary>1. Menampilkan employee, jabatan dan lokasi kerja</summary>
  
  ```sql

SELECT
	e.employeeNumber, 
	concat_ws(' ', e.firstName, e.lastName) AS fullname,
	e.jobTitle,
	o.officeCode,
	o.city,
	o.country  
FROM
	employees AS e
INNER JOIN offices AS o using(officeCode);
```
  <img src="https://user-images.githubusercontent.com/67408325/236352631-89d21179-1ac1-4fbc-be58-210aae2bf695.png" width="80%">
</details>
<details><summary>2. Menampilkan customer yang total pembelian nya > 150 juta</summary>
  
  ```sql
SELECT
	c.customerNumber,
	c.customerName, 
	sum(amount) AS total_pembelian
FROM
	payments AS p
INNER JOIN customers AS c
		USING(customerNumber)
GROUP BY customerNumber
HAVING total_pembelian > 150000;
```
  
  <img src="https://user-images.githubusercontent.com/67408325/236238541-8c4b82e5-1927-41be-a2cc-3ef92a9e9418.png" width="80%">
</details>
<details><summary>3. Menampilkan data order pada jangka waktu tertentu</summary>
  
  ```sql
SELECT
	o.orderNumber,
	o.orderDate,
	o.requiredDate,
	o.shippedDate,
	o.status,
	c.customerNumber,
	c.customerName,
	o.comments
FROM
	orders AS o
INNER JOIN customers AS c
		USING(customerNumber)
WHERE
	orderDate BETWEEN '2005-02-01' AND '2005-03-01';
```
  <img src="https://user-images.githubusercontent.com/67408325/236249786-05325bfa-890b-4b15-82eb-623f1f8eb28b.png" width="80%">
</details>
<details><summary>4. Menampilkan employee berapa jumlah employee yang ada pada setiap kantor yang ada</summary>
  
  ```sql
SELECT
	o.officeCode,
	o.city,
	count(employeeNumber) AS jumlah_karyawan
FROM
	employees AS e
INNER JOIN offices AS o
		USING(officeCode)
GROUP BY
	officeCode;

```
  
  <img src="https://user-images.githubusercontent.com/67408325/236253601-c377353f-ff48-42ae-939a-9cfb12c2d65b.png" width="80%">
</details>
<details><summary>5. menampilkan product yang termasuk kategori Planes, Truck and Buses</summary>
  
  ```sql
SELECT p.* FROM products AS p WHERE productLine IN('Trucks and Buses', 'Planes');
```
  
  <img src="https://user-images.githubusercontent.com/67408325/236255093-a5d44781-88f6-41ce-bd66-5b7e9e65f027.png" width="80%">
</details>
<details><summary>6. Menampilkan total_harga_pembelian per-order</summary>
  
  ```sql
SELECT
	od.orderNumber,
	p.productCode,
	p.productName,
	p.productVendor,
	c.customerName,
	od.quantityOrdered,
	od.priceEach,
	od.priceEach * od.quantityOrdered AS total_harga_pembelian
FROM
	orderdetails AS od
INNER JOIN products AS p
		USING(productCode)
INNER JOIN orders AS o using(orderNumber)
INNER JOIN customers AS c ON o.customerNumber = c.customerNumber;
```
  <img src="https://user-images.githubusercontent.com/67408325/236258246-cf21c08c-5ad2-4a7e-8d26-fb66a1889760.png" width="80%">
</details>
<details><summary>7. Menampilkan customer dan karyawan yang melayani customer tersebut</summary>
  
  ```sql
SELECT
	c.customerNumber,
	c.customerName,
	e.employeeNumber,
	concat_ws(' ', e.firstName, e.lastName) AS employee_handler
FROM
	customers AS c
INNER JOIN employees AS e ON
	e.employeeNumber = c.salesRepEmployeeNumber;
```
  
  <img src="https://user-images.githubusercontent.com/67408325/236259721-d36824b3-88c0-474e-bede-c8523f405794.png" width="80%">
</details>
<details><summary>8. Menghitung customer berdasarkan negara</summary>
  
  ```sql
SELECT
	c.country,
	count(customerNumber) AS jumlah_customer
FROM
	customers AS c
GROUP BY
	country;
```
  <img src="https://user-images.githubusercontent.com/67408325/236260924-e8f40f68-ddb8-4e28-9490-cb0de76087b4.png" width="80%">
</details>
<details><summary>9. Menampilkan customer dengan kondisi creditLimit</summary>
  
  ```sql
SELECT
	c.customerNumber,
	c.customerName,
	c.country,
	c.creditLimit
FROM
	customers AS c
WHERE
	c.creditLimit = 0;
```
  <img src="https://user-images.githubusercontent.com/67408325/236350717-64bd55e6-e9d5-4424-b150-0948bd15534c.png" width="80%">
</details>
<details><summary>10. Menghitung jumlah order yang ada pada sebuah product</summary>
  
  ```sql
SELECT
	p.productCode,
	p.productName, 
	count(*) AS jumlah_penjualan 
FROM
	orders AS o
INNER JOIN orderdetails AS o2 using(orderNumber)
INNER JOIN products AS p ON o2.productCode = p.productCode
GROUP BY p.productCode;
```
  <img src="https://user-images.githubusercontent.com/67408325/236351825-c73cfcaf-829c-473b-860e-4dd8585cdf2b.png" width="80%">
</details>
