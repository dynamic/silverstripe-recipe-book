<div class="container">
    <!-- Category Title -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-3">$Title</h1>
            <% if $Content %>
                <p class="lead">$Content</p>
            <% end_if %>
        </div>
    </div>

    <!-- Recipes List -->
    <% if $RecipeList.Sort('Title') %>
        <div class="row">
            <% loop $RecipeList.Sort('Title') %>
                <% include RecipeSummary %>
            <% end_loop %>
        </div>
    <% else %>
        <div class="row">
            <div class="col-12">
                <p>No recipes found in this category.</p>
            </div>
        </div>
    <% end_if %>
</div>

<!-- Elemental Area -->
<div>
    $ElementalArea
</div>