<style>
	.star-rating {
		display: flex;
		direction: row-reverse;
		justify-content: center;
	}

	.star {
		font-size: 2rem;
		cursor: pointer;
		color: gray;
	}

	.star.filled {
		color: gold;
	}
</style>

<script>
	document.addEventListener("DOMContentLoaded", function() {
		const starRatings = document.querySelectorAll('.star-rating');

		starRatings.forEach(starRating => {
			const stars = starRating.querySelectorAll('.star');

			// stars.forEach((star, index) => {
			// 	if (index < defaultRating) {
			// 		star.classList.add('filled');
			// 	}
			// });
			stars.forEach((star, index) => {
				star.addEventListener('mouseenter', () => {
					const defaultRating = parseInt(starRating.dataset.review);
					stars.forEach((s, i) => {
						i <= index ? s.classList.add('filled') : s.classList.remove('filled');
					});
				});
			});
			starRating.addEventListener('mouseleave', () => {
				const defaultRating = parseInt(starRating.dataset.review);
				stars.forEach((star, index) => {
					index < defaultRating ? star.classList.add('filled') : star.classList.remove('filled');
				});
			});
		});

		starRatings.forEach(starRating => {
			const stars = starRating.querySelectorAll('.star');
			const review = starRating.getAttribute('data-review');

			function setStars(review) {
				stars.forEach(star => {
					star.classList.toggle('filled', star.getAttribute('data-value') <= review);
				});
			}
			setStars(review);
			stars.forEach(star => {
				star.addEventListener('click', function() {
					const newReview = this.getAttribute('data-value');
					starRating.setAttribute('data-review', newReview);
					setStars(newReview);

					const id = starRating.getAttribute('data-id');
					// console.log(id, window.location.href, newReview)
					// Send the new review value to the server
					fetch('update_review.php', {
							method: 'POST',
							headers: {
								'Content-Type': 'application/json',
							},
							body: JSON.stringify({
								id: id,
								review: newReview,
								update_review: true
							})
						})
						.then(response => response.json())
						.then(data => {
							console.log('Success:', data);
							alert('Review updated!!!\n' + data.message);
						})
						.catch((error) => {
							console.error('Error:', error);
						});
				});
			});
		});
	});
</script>
<table id="dataTable" class="table table-bordered table-hover" cellspacing="0">
	<thead>
		<tr>
			<th>IBSN</th>
			<th>Title</th>
			<th>Category</th>
			<th>Borrower</th>
			<th>DateBorrowed</th>
			<th>DueDate</th>
			<th>Status</th>
			<th>Fine</th>
			<th>Review</th>
		</tr>
	</thead>
	<tbody>
		<?php
		$mydb->setQuery("SELECT * FROM `tblbooks` b, `tbltransaction` t ,`tblborrower` s
				  					WHERE b.IBSN=t.IBSN AND t.BorrowerId=s.BorrowerId AND s.BorrowerId=" . $_SESSION['BorrowerId']);
		loadresult();

		function loadresult()
		{
			global $mydb;
			$cur = $mydb->loadResultlist();
			foreach ($cur as $result) {
				$dueDate = new DateTime($result->DueDate);
				$currentDate = new DateTime();
				$interval = $dueDate->diff($currentDate);
				$daysLate = $interval->days;
				if ($currentDate > $dueDate && $daysLate >= 3 && $result->Status == 'Pending') {
					$fine = ($daysLate - 2) * 50;
				} else {
					$fine = 0;
				}
				$result->review = $result->review ?? 0;
				echo '<tr>';
				echo '<td><a title="View Book Details" href="index.php?view=view&id=' . $result->TransactionID . '" >' . $result->IBSN . '</a></td>';
				echo '<td >' . $result->BookTitle . '</td>';
				// echo '<td>'.  $result->BookDesc.'</td>'; 
				echo '<td>' . $result->Category . '</td>';
				echo '<td>' . $result->Firstname . ' ' . $result->MiddleName . ' ' . $result->Lastname . '</td>';
				echo '<td>' . $result->DateBorrowed . '</td>';
				echo '<td>' . $result->DueDate . '</td>';
				echo '<td>' . $result->Status . '</td>';
				echo '<td> Rs.' . number_format($fine, 2) . '</td>';
				if ($result->Status == 'Cancelled' ||  $result->Status == 'Pending') {
					echo '<td>You can not Rate.</td>';
				} else {
				echo '<td> <div class="star-rating" data-id="' . $result->TransactionID . '" data-review="' . $result->review . '">
                    <span class="star" data-value="1">&#9733;</span>
                    <span class="star" data-value="2">&#9733;</span>
                    <span class="star" data-value="3">&#9733;</span>
                    <span class="star" data-value="4">&#9733;</span>
                    <span class="star" data-value="5">&#9733;</span>
                	</div>
              	</td>';
				}
				echo '</tr>';
			}
		}
		?>
	</tbody>

</table>