<div class="container">
    <!-- Full-Width Recipe Image -->
    <div class="row">
        <div class="col-12">
            <img src="$Image.URL" class="img-fluid mb-4" alt="$Image.Title">
        </div>
    </div>

    <!-- Title and Recipe Info -->
    <div class="row">
        <div class="col-12">
            <h1 class="card-title">$Title</h1>
            <div class="d-flex align-items-center text-muted mb-3">
                <div class="me-4">
                    <i class="bi bi-alarm"></i> Prep: $PreparationTime minutes
                </div>
                <div class="me-4">
                    <i class="bi bi-clock"></i> Cook: $CookTime minutes
                </div>
                <div>
                    <i class="bi bi-people"></i> Servings: $Servings
                </div>
            </div>
        </div>
    </div>

    <!-- Social Sharing -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center">
                <h3 class="me-3 text-muted" style="font-size: 1.25rem;">Share This Recipe:</h3>
                <a href="https://www.facebook.com/sharer/sharer.php?u=$AbsoluteLink" class="me-2 text-decoration-none" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="https://twitter.com/intent/tweet?url=$AbsoluteLink&text=$Title" class="me-2 text-decoration-none" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-twitter"></i>
                </a>
                <a href="https://www.instagram.com" class="me-2 text-decoration-none" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="https://www.pinterest.com/pin/create/button/?url=$AbsoluteLink&description=$Title" class="me-2 text-decoration-none" target="_blank" rel="noopener noreferrer">
                    <i class="bi bi-pinterest"></i>
                </a>
                <a href="mailto:?subject=Check%20out%20this%20recipe!&body=Hi,%0A%0ACheck%20out%20this%20recipe%20I%20found:%20$AbsoluteLink%0A%0AEnjoy!" class="text-decoration-none">
                    <i class="bi bi-envelope"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Recipe Info and About -->
    <div class="row">
        <div class="col-12">
            <h3>About this Recipe</h3>
            <p>$Content</p>
        </div>
    </div>

    <!-- Ingredients and Directions -->
    <div class="row mt-4">
        <div class="col-md-4">
            <h2>Ingredients</h2>
            <ul class="list-group mb-4">
                <% loop $Ingredients.Sort('Sort') %>
                    <li class="list-group-item">
                        <input type="checkbox" id="ingredient-$ID">
                        <label for="ingredient-$ID">$Title.Plain</label>
                    </li>
                <% end_loop %>
            </ul>
        </div>
        <div class="col-md-8">
            <h2>Instructions</h2>
            <% loop $Directions.Sort('Sort') %>
                <div class="mb-3 d-flex align-items-center">
                    <span class="me-2">$Pos.</span>
                    <span>$Title</span>
                </div>
            <% end_loop %>
        </div>
    </div>
</div>

<!-- Elemental Area -->
<div>
    $ElementalArea
</div>