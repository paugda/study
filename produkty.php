<?php
	require_once('header.php');

?>
<main role="main" class="container">
<div class="starter-template">
<?php

	if(isset($_GET['edytuj'])) //edycja produktu
	{
		if(isset($_POST['zapisz']))
		{
			$stmt = $db->prepare('UPDATE products SET name=:name, kcal=:kcal, category=:category WHERE id_product=:id');
			$stmt->bindValue(':id', $_POST['id'], SQLITE3_INTEGER);
			$stmt->bindValue(':name', $_POST['name'], SQLITE3_TEXT);
			$stmt->bindValue(':category', $_POST['category'], SQLITE3_TEXT);
			$stmt->bindValue(':kcal', $_POST['kcal'], SQLITE3_INTEGER);
			$result = $stmt->execute();
			echo '<div class="alert alert-success"><strong>Sukces!</strong> Zaktualizowano produkt o ID=<b>'.$_POST['id'].'</b></div>';					
		}
		$stmt = $db->prepare('SELECT * FROM products WHERE id_product=:id LIMIT 1');
		$stmt->bindValue(':id', $_GET['edytuj'], SQLITE3_INTEGER);
		$result = $stmt->execute();
		$row = $result->fetchArray();
		if($row)
		{
			?>
			<h1>Edycja produktu ID=<?php echo $row['id_product'];?></h1>
			<div class="row justify-content-center align-items-center h-100">
			<div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">	
			<form action="produkty.php?edytuj=<?php echo $row['id_product'];?>" method="post">
			<input type="hidden" name="id" value="<?php echo $row['id_product'];?>">
			<div class="form-group">
				<label for="name"><b>Nazwa produktu:</b></label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Wpisz nową nazwę produktu" value="<?php echo $row['name'];?>" required>
			</div>
			<div class="form-group">
				<label for="kcal"><b>KCAL:</b></label>
				<input type="number" class="form-control" id="kcal" name="kcal" placeholder="Wpisz nową liczbę kcal" value="<?php echo $row['kcal'];?>" required>
			</div>
			<div class="form-group">
			<label for="category">Kategoria</label>
			<select class="form-control" id="category" name="category">
			<?php
			foreach($kategorie as $value)
			{
				if($value == $row['category'])
				{
					echo '<option value="'.$value.'" selected>';
				}
				else
				{
					echo '<option value="'.$value.'">';
				}
				echo $value;
				echo '</option>';
			}
			?>
			</select>
			</div>			
				<button type="submit" name="zapisz" class="btn btn-default">Zapisz</button>
			</form>	
			</div>
			</div>
			<?php
		}
		else
		{
			echo 'Nie ma produktu o takim ID! <a href="produkty.php">wróć do produktów</a>';
		}
	}
	else if(isset($_GET['dodaj'])) //dodawanie nowego produktu
	{
		if(isset($_POST['dodaj']))
		{
			$stmt = $db->prepare('INSERT INTO products (name, kcal, category) VALUES (:name, :kcal, :category)');
			$stmt->bindValue(':name', $_POST['name'], SQLITE3_TEXT);
			$stmt->bindValue(':category', $_POST['category'], SQLITE3_TEXT);
			$stmt->bindValue(':kcal', $_POST['kcal'], SQLITE3_INTEGER);
			$result = $stmt->execute();
			echo '<div class="alert alert-success"><strong>Sukces!</strong> Popranie dodano nowy produkt do spisu!</b></div>';					
		}
	?>
	
	<h1>Dodawanie nowego produktu</h1>
	<div class="row justify-content-center align-items-center h-100">
	<div class="col col-sm-6 col-md-6 col-lg-4 col-xl-3">	
	<form action="produkty.php?dodaj=nowy" method="post">
	<div class="form-group">
		<label for="name"><b>Nazwa produktu:</b></label>
		<input type="text" class="form-control" id="name" name="name" placeholder="Wpisz nazwę produktu" required>
	</div>
	<div class="form-group">
		<label for="kcal"><b>KCAL:</b></label>
		<input type="number" class="form-control" id="kcal" name="kcal" placeholder="Wpisz liczbę kcal" required>
	</div>
	<div class="form-group">
	<label for="category">Kategoria</label>
	<select class="form-control" id="category" name="category">
	<?php
	foreach($kategorie as $value)
	{
		if($value == $row['category'])
		{
			echo '<option value="'.$value.'" selected>';
		}
		else
		{
			echo '<option value="'.$value.'">';
		}
		echo $value;
		echo '</option>';
	}
	?>
	</select>
	</div>			
		<button type="submit" name="dodaj" class="btn btn-default">Dodaj</button>
	</form>	
	</div>
	</div>
	<?php
	}
	else
	{
		if(isset($_GET['usun']))
		{
			$stmt = $db->prepare('DELETE FROM products WHERE id_product=:id');
			$stmt->bindValue(':id', $_GET['usun'], SQLITE3_INTEGER);
			$result = $stmt->execute();
			echo '<div class="alert alert-success"><strong>Sukces!</strong> Usunięto produkt o ID=<b>'.$_GET['usun'].'</b></div>';	
		}
?>
        <h1>Lista produktów i ich kalorie</h1>
		<table id="produkty" class="table table-striped table-bordered" style="width:100%">
		<thead>
		  <tr>
			<th>ID</th>
			<th>Nazwa</th>
			<th>KCAL</th>
			<th>Kategoria</th>
			<th>Akcja</th>
		  </tr>
		</thead>		
		<tbody>
		<?php
		$stmt = $db->prepare('SELECT * FROM products ORDER BY id_product');
		$result = $stmt->execute();
		while($row = $result->fetchArray())
		{
			echo '<tr>';
			echo '<td>'.$row['id_product'].'</td>';
			echo '<td>'.$row['name'].'</td>';
			echo '<td>'.$row['kcal'].'</td>';
			echo '<td>'.$row['category'].'</td>';
			echo '<td><a href="produkty.php?edytuj='.$row['id_product'].'" class="btn btn-info" role="button">Edytuj</a> <a href="produkty.php?usun='.$row['id_product'].'" class="btn btn-info" role="button">Usuń</a></td>';
			echo '</tr>';
		}
		?>
		</tbody>
		<tfoot>
		  <tr>
			<th>ID</th>
			<th>Nazwa</th>
			<th>KCAL</th>
			<th>Kategoria</th>
			<th>Akcja</th>
		  </tr>
		</tfoot>		
		</table>
		</div>

    </main><!-- /.container -->
<?php
	require_once('footer.php');
?>
<script>
$(document).ready(function() {
    $('#produkty').DataTable( {
        "language": {
            "url": "js/Polish.json"
        }
    } );
} );
</script>
<?php
}
?>