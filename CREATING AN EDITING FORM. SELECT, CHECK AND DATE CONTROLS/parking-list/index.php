<?php
require('data/declar-data.php');
?>
<!DOCTYPE html>
<html> 
<head>
	<title>Список машин</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/main-style.css">
	<link rel="stylesheet" type="text/css" href="css/cars-style.css">
</head>
<body>
	<header>
		<h1> Адреса автостоянки: <span class="car-adress"><?php echo $data['info']['adress']; ?> </span> </h1>   
		<h2> Директор :  <span class="car-director"><?php echo $data['info']['director']; ?>  </span> </h2> 
		<a href ="forms/edit_cars.php">Редагувати сторінку</a>
	</header>
	<section> 
		<table >
			<thead >
				<tr> 
					<th> № </th>
					<th>Марка</th>
					<th>Держ.номер</th>
					<th>Номер місця </th>
					<th>  </th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data['cars'] as $key => $car): ?> 
					<?php
					$row_class='row';
					if($car['brand'] == 'Ferrari' ){
						$row_class = 'car-first';
					}
					if($car['brand'] == 'Mercedes-Benz' ){
						$row_class = 'car-second';
					}
					if($car['brand'] == 'Rolls - Royce'){
						$row_class = 'car-first';
					}
					if($car['brand'] == 'Bugatti'){
						$row_class = 'car-second';
					}
					if($car['brand'] ==  'Chevrolet'  ){
						$row_class = 'car-first';
					}
				    ?>
				<tr class='<?php echo $row_class; ?>'> 
					<td> <?php echo ($key+1 ); ?> </td>
					<td> <?php echo $car['brand']; ?>  </td>
					<td> <?php echo $car['number']; ?>  </td>
					<td> 
					<?php 
					$parking_and_date=new Datetime($car['pad']);
					echo date_format($parking_and_date, 'Y');
					?>  
					</td>
					<td>
						<a href = "forms/edit-car.php?file=<?php echo $car['file']; 
						?>">Редагування</a>
					</td>
				</tr>
			<?php endforeach; ?> 
			</tbody>
	</section>
</body>
</html> 

