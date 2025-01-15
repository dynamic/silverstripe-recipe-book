<% base_tag %>
<div class="container">
    <!-- Page Title and Content -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="mb-3">$Title</h1>
            <% if $Content %>
                <p class="lead">$Content</p>
            <% end_if %>
        </div>
    </div>

    <!-- Top-Level Recipe Categories -->
    <% loop $Children %>
        <div class="row mb-5">
            <!-- Category Title -->
            <div class="col-12">
                <h2 class="mb-4">$Title</h2>
            </div>

            <!-- Recipes in Category -->
            <% loop $RecipeList.Limit(3).Sort('Title') %>
                <% include RecipeSummary %>
            <% end_loop %>

            <!-- View All Button -->
            <div class="col-12 text-center">
                <a href="$Link" class="btn btn-secondary mt-3">View All $Title</a>
            </div>
        </div>
    <% end_loop %>
</div>

<!-- Elemental Area -->
<div>
    $ElementalArea
</div>