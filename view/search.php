    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Book Display</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js" integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            /* Existing CSS */
            body {
                font-family: 'Roboto', sans-serif;
                background-color: #f8f9fa;
                color: #333;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
            }

            .row {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                justify-content: flex-start;
            }

            .card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                border-radius: 10px;
                overflow: hidden;
                border: none;
                background-color: #ffffff;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            .card:hover {
                transform: translateY(-8px);
                box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
            }

            .card-img-top {
                width: 100%;
                height: 200px;
                object-fit: cover;
                border-bottom: 2px solid #eee;
            }

            .card-body {
                padding: 20px;
                text-align: center;
            }

            .card-title {
                font-size: 1.25rem;
                font-weight: 600;
                color: #343a40;
                margin-bottom: 10px;
                text-transform: uppercase;
            }

            .card-text {
                font-size: 0.9rem;
                color: #6c757d;
            }

            .card-text:nth-child(4) {
                font-size: 1rem;
                font-weight: 600;
                color: #495057;
            }

            .btn {
                font-size: 0.875rem;
                font-weight: 500;
                border-radius: 5px;
                transition: background-color 0.3s ease, color 0.3s ease;
            }

            .btn-outline-secondary {
                color: #6c757d;
                border-color: #6c757d;
            }

            .btn-outline-secondary:hover {
                color: #fff;
                background-color: #6c757d;
                border-color: #6c757d;
            }

            .alert {
                font-size: 1rem;
                font-weight: 500;
                background-color: #ffeeba;
                color: #856404;
                border: 1px solid #ffeeba;
                border-radius: 5px;
            }

            select.form-select {
                padding: 5px 10px;
                font-size: 0.9rem;
                border-radius: 5px;
                border: 1px solid #ddd;
                transition: border-color 0.3s ease, box-shadow 0.3s ease;
            }

            select.form-select:focus {
                box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
                border-color: #80bdff;
            }

            h2 {
                font-size: 1.5rem;
                font-weight: 700;
                color: #343a40;
                margin-bottom: 20px;
                padding: 10px;
                background-color: #f8f9fa;
                border-radius: 5px;
            }

            .col-md-3 {
                margin: 35px;
            }

            .breadcrumb-item a {
                color: #007bff;
                text-decoration: none;
            }

            .breadcrumb-item a:hover {
                text-decoration: underline;
            }

            .card-body label {
                font-size: 0.875rem;
                color: #495057;
                margin-right: 10px;
            }

            .d-flex select.form-select {
                width: auto;
                min-width: 180px;
            }

            @media (max-width: 768px) {
                .col-md-3 {
                    flex: 1 1 100%;
                    margin: 15px 0;
                }

                .d-flex {
                    flex-direction: column;
                    align-items: stretch;
                }

                .d-flex select.form-select {
                    margin-bottom: 10px;
                }
            }
        </style>


    </head>

    <body>

        <?php include 'header.php'; ?>
        <div class="container mt-4">
            <div class="row mt-5">
                <div class="col-12 mb-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<%=url%>/index.jsp">Trang chủ</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tìm kiếm sản phẩm</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex gap-2">
                    <select class="form-select d-inline-block w-auto" id="genreFilter">
                        <option selected>Filter by Genre</option>
                        <option value="fiction">Fiction</option>
                        <option value="non-fiction">Non-fiction</option>
                        <option value="romance">Romance</option>
                        <option value="science-fiction">Science Fiction</option>
                    </select>
                    <select class="form-select d-inline-block w-auto" id="priceFilter">
                        <option selected>Filter by Price</option>
                        <option value="low">Price: High to Low</option>
                        <option value="medium">Price: Low to High</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <h2>Search results for keyword "<?= htmlspecialchars($keyWord ?? '') ?>"</h2>
                <?php if (!empty($sachs)): ?>
                    <?php foreach ($sachs as $sach): ?>
                        <div class="col-md-3 mb-4" data-genre="<?= htmlspecialchars($sach['the_loai']) ?>">
                            <div class="card">
                                <img src="<?= !empty($sach['anh_bia']) ? htmlspecialchars($sach['anh_bia']) : 'https://via.placeholder.com/150' ?>"
                                    class="card-img-top" alt="<?= htmlspecialchars($sach['ten_sach']) ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($sach['ten_sach']) ?></h5>
                                    <p class="card-text">Author: <?= htmlspecialchars($sach['ten_tac_gia']) ?></p>
                                    <p class="card-text">Genre: <?= htmlspecialchars($sach['the_loai']) ?></p>
                                    <p class="card-text">Price: <?= number_format($sach['gia_ban'], 0, ',', '.') ?> VND</p>
                                    <form action="view/addCartSearch.php" method="POST">
                                        <input type="hidden" name="bookId" value="<?= $sach['ma_sach'] ?>"> 
                                        <input type="hidden" name="so_luong" value="1"> 
                                        <button type="submit" class="btn btn-outline-secondary btn-sm w-100">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-warning text-center" role="alert">
                            No books found for the keyword "<?= htmlspecialchars($keyWord ?? '') ?>"
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </body>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const genreFilter = document.getElementById('genreFilter');
            const priceFilter = document.getElementById('priceFilter');

            const bookCards = document.querySelectorAll('.col-md-3');

            genreFilter.addEventListener('change', applyFilters);
            priceFilter.addEventListener('change', applyFilters);

            function applyFilters() {
                const selectedGenre = genreFilter.value;
                const selectedPrice = priceFilter.value;

                bookCards.forEach(card => {
                    const genre = card.dataset.genre;
                    const priceElement = card.querySelector('.card-text:nth-child(4)');
                    const price = parsePrice(priceElement.textContent);

                    const genreMatch = selectedGenre === 'Filter by Genre' || genre.toLowerCase() === selectedGenre;

                    let priceMatch = true;
                    if (selectedPrice === 'low') {
                        bookCards.forEach(c => c.style.display = 'block');
                        const sortedCards = Array.from(bookCards).sort((a, b) => {
                            const priceA = parsePrice(a.querySelector('.card-text:nth-child(4)').textContent);
                            const priceB = parsePrice(b.querySelector('.card-text:nth-child(4)').textContent);
                            return priceB - priceA;
                        });

                        const container = card.closest('.row');
                        sortedCards.forEach(sortedCard => container.appendChild(sortedCard));

                        priceMatch = true;
                    } else if (selectedPrice === 'medium') {
                        bookCards.forEach(c => c.style.display = 'block');
                        const sortedCards = Array.from(bookCards).sort((a, b) => {
                            const priceA = parsePrice(a.querySelector('.card-text:nth-child(4)').textContent);
                            const priceB = parsePrice(b.querySelector('.card-text:nth-child(4)').textContent);
                            return priceA - priceB;
                        });

                        const container = card.closest('.row');
                        sortedCards.forEach(sortedCard => container.appendChild(sortedCard));

                        priceMatch = true;
                    }

                    card.style.display = (genreMatch && priceMatch) ? 'block' : 'none';
                });
            }

            function parsePrice(priceText) {
                return parseFloat(priceText.replace(/[^\d]/g, ''));
            }

            function populateGenreFilter() {
                const genres = new Set();
                bookCards.forEach(card => {
                    const genre = card.dataset.genre;
                    if (genre) genres.add(genre.toLowerCase());
                });

                const genreSelect = document.getElementById('genreFilter');

                while (genreSelect.options.length > 1) {
                    genreSelect.remove(1);
                }

                genres.forEach(genre => {
                    const option = document.createElement('option');
                    option.value = genre;
                    option.textContent = genre.charAt(0).toUpperCase() + genre.slice(1);
                    genreSelect.appendChild(option);
                });
            }

            populateGenreFilter();
        });
    </script>

    </html>