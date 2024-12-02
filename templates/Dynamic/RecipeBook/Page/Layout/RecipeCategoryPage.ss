<div class="container mt-4">
    <div class="row">
    <% loop $paginatedList %>
        <div class="card col-md-4">
            <div class="recipe-img-holder">
                <a href="$Link" title="Go to the $Title.XML page">
                    <% if $Image %>
                        <img src="$Image.URL" alt="$Image.Title" class="img-fluid recipe-img" />
                    <% else %>
                        <img src="_resources/themes/cheesesociety/images/recipe-default.jpg" class="img-fluid recipe-img">
                    <% end_if %>
                    <% if $Servings || $PrepTime || $CookTime || $Difficulty %>
                        <div class="recipe-overlay">
                            <div class="inner">
                                <% if $PrepTime %>
                                    <div class="pb-1">
                                        <i class="far fa-clock p-1"></i> 
                                            Prep Time: $PrepTime
                                    </div>
                                <% end_if %>
                                <% if $CookTime %>
                                    <div class="pb-1">
                                        <i class="far fa-clock p-1"></i> 
                                            Cook Time: $CookTime
                                    </div>
                                <% end_if %>
                                <% if $Servings %>
                                    <div class="pb-1">
                                        <i class="fas fa-utensils p-1"></i> 
                                            Servings: $Servings
                                    </div>
                                <% end_if %>
                                <% if $Difficulty %>
                                    <div class="pb-1">
                                        <i class="fas fa-tachometer-alt p-1"></i> 
                                            Difficulty: $Difficulty
                                    </div>
                                <% end_if %>
                            </div>
                        </div>
                    <% end_if %>
                </a>
            </div>
            <div class="card-body">
                <h4 class="recipe-title text-center">$Title</h4>
            </div>
            <div class="card-body text-center pt-0">
                <a href="$Link" class="btn recipe-link btn-primary">View Recipe</a>
            </div>
        </div>
    <% end_loop %>
    </div>
</div>

<% if $paginatedList.MoreThanOnePage %>
    <nav aria-label="Recipe Category Navigation">
        <ul class="pagination justify-content-center">
    <% if $paginatedList.NotFirstPage %>
            <li class="page-item disabled">
                <a class="page-link" href="$paginatedList.PrevLink" tabindex="-1">Previous</a>
            </li>
    <% end_if %>
    <% loop $paginatedList.PaginationSummary %>
        <% if $CurrentBool %>
            <li class="page-item active">
                <span class="page-link">$PageNum<span class="sr-only">(current)</span></span>
            </li>
        <% else %>
            <% if $Link %>
            <li class="page-item"><a class="page-link" href="$Link">$PageNum</a></li>
            <% else %>
                ...
            <% end_if %>
        <% end_if %>
    <% end_loop %>
    <% if $paginatedList.NotLastPage %>
            <li class="page-item">
                <a class="page-link" href="$paginatedList.NextLink">Next</a>
            </li>
    <% end_if %>
        </ul>
    </nav>
<% end_if %>