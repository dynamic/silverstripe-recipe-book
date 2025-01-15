<div class="container">
    <!-- Full-Width Recipe Image -->
    <% if $Image %>
        <div class="row">
            <div class="col-12">
                <img src="$Image.URL" class="img-fluid mb-4" alt="$Image.Title">
            </div>
        </div>
    <% end_if %>
    <div class="row">
        <div class="col-12">
            <img src="$Image.URL" class="img-fluid mb-4" alt="$Image.Title">
        </div>
    </div>

    <!-- Title and Recipe Info -->
    <div class="row">
        <div class="col-12">
            <% if $PrimaryCategory %>
                <p class="text-uppercase text-muted small mb-1">$PrimaryCategory.Title</p>
            <% end_if %>
            <h1 class="card-title">$Title</h1>
            <div class="d-flex align-items-center text-muted mb-3">
                <div class="me-4">
                    <i class="bi bi-alarm"></i> Prep: $PrepTime
                </div>
                <div class="me-4">
                    <i class="bi bi-clock"></i> Cook: $CookTime
                </div>
                <div>
                    <i class="bi bi-people"></i> Servings: $Servings
                </div>
            </div>
            <!-- Additional Categories and Share This Recipe -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <% if $CategoryList %>
                        <h5>Additional Categories:</h5>
                        <ul class="list-inline">
                            <% loop $CategoryList %>
                                <% if $ID != $CurrentCategory.ID %>
                                    <li class="list-inline-item">
                                        <a href="$Link" class="btn btn-outline-secondary btn-sm">$Title</a>
                                    </li>
                                <% end_if %>
                            <% end_loop %>
                        </ul>
                    <% end_if %>
                </div>
                <div class="col-md-6">
                    <h5>Share This Recipe:</h5>
                    <div class="d-flex">
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
                    <li class="list-group-item d-flex align-items-start">
                        <input type="checkbox" id="ingredient-$ID" class="me-2 align-self-start mt-1" aria-label="Ingredient: $Title.Plain">
                        <label for="ingredient-$ID" class="flex-grow-1">$Title.Plain</label>
                    </li>
                <% end_loop %>
            </ul>
        </div>
        <div class="col-md-8">
            <h2>Instructions</h2>
            <ol class="list-group list-group-numbered">
                <% loop $Directions.Sort('Sort') %>
                    <li class="list-group-item d-flex align-items-start">
                        <span class="ms-2">$Title</span>
                    </li>
                <% end_loop %>
            </ol>
        </div>
    </div>

<!-- Elemental Area -->
<div class="mt-4">
    $ElementalArea
</div>