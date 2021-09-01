# Changelog

## [1.0.1](https://github.com/dynamic/silverstripe-recipe-book/tree/1.0.1) (2021-08-31)

[Full Changelog](https://github.com/dynamic/silverstripe-recipe-book/compare/1.0.0...1.0.1)

**Fixed bugs:**

- BUG default sort value not assigned on ingredient/direction creation [\#41](https://github.com/dynamic/silverstripe-recipe-book/issues/41)

**Closed issues:**

- FEATURE RecipeAdmin - rename to Recipes [\#35](https://github.com/dynamic/silverstripe-recipe-book/issues/35)

**Merged pull requests:**

- BUGFIX default sort value not set when creating ingredient/direction [\#42](https://github.com/dynamic/silverstripe-recipe-book/pull/42) ([muskie9](https://github.com/muskie9))
- BUGFIX if RecipePage does not exist it errors when creating new in some cases [\#40](https://github.com/dynamic/silverstripe-recipe-book/pull/40) ([muskie9](https://github.com/muskie9))
- Added permission checks for directions [\#39](https://github.com/dynamic/silverstripe-recipe-book/pull/39) ([mak001](https://github.com/mak001))
- TESTS Travis and Scrutinizer [\#38](https://github.com/dynamic/silverstripe-recipe-book/pull/38) ([jsirish](https://github.com/jsirish))
- TESTS initial GitHub workflow [\#37](https://github.com/dynamic/silverstripe-recipe-book/pull/37) ([jsirish](https://github.com/jsirish))
- REFACTOR RecipePage - remove summary and searchable fields [\#36](https://github.com/dynamic/silverstripe-recipe-book/pull/36) ([jsirish](https://github.com/jsirish))
- BUGFIX remove all Weight references [\#34](https://github.com/dynamic/silverstripe-recipe-book/pull/34) ([jsirish](https://github.com/jsirish))
- REFACTOR Repo cleanup, README [\#33](https://github.com/dynamic/silverstripe-recipe-book/pull/33) ([jsirish](https://github.com/jsirish))
- REFACTOR CMS Design, remove project specific data [\#32](https://github.com/dynamic/silverstripe-recipe-book/pull/32) ([jsirish](https://github.com/jsirish))
- REFACTOR switch to dynamic/silverstripe-linkable [\#31](https://github.com/dynamic/silverstripe-recipe-book/pull/31) ([jsirish](https://github.com/jsirish))

## [1.0.0](https://github.com/dynamic/silverstripe-recipe-book/tree/1.0.0) (2020-03-26)

[Full Changelog](https://github.com/dynamic/silverstripe-recipe-book/compare/dc05f252551ba4ca092014170b20113ef2b6c09d...1.0.0)

**Implemented enhancements:**

- Adjust directions field to be WYSIWYG field [\#11](https://github.com/dynamic/silverstripe-recipe-book/issues/11)

**Fixed bugs:**

- Category error on RecipeListPage [\#15](https://github.com/dynamic/silverstripe-recipe-book/issues/15)
- Servings field reverting back to 0 on save&publish [\#10](https://github.com/dynamic/silverstripe-recipe-book/issues/10)

**Closed issues:**

- RecipePage - Categories - Add readonly Primary Category field [\#29](https://github.com/dynamic/silverstripe-recipe-book/issues/29)
- Recipe Categories unlink [\#26](https://github.com/dynamic/silverstripe-recipe-book/issues/26)
- RecipeLanding FeaturedList & PaginatedList with multiple categories [\#25](https://github.com/dynamic/silverstripe-recipe-book/issues/25)
- don't allow tagging of parent category on a recipe detail [\#24](https://github.com/dynamic/silverstripe-recipe-book/issues/24)
- Consolidate RecipeCategory and RecipeList into one page type [\#22](https://github.com/dynamic/silverstripe-recipe-book/issues/22)
- Getter for Category Page FeaturedList [\#14](https://github.com/dynamic/silverstripe-recipe-book/issues/14)
- Remove category from dropdown once it's assigned to a RecipeListPage [\#13](https://github.com/dynamic/silverstripe-recipe-book/issues/13)
- Getter for Related Recipes on a Recipe Detail page [\#12](https://github.com/dynamic/silverstripe-recipe-book/issues/12)
- Hide parent category from the recipes MA [\#9](https://github.com/dynamic/silverstripe-recipe-book/issues/9)
- RecipeListPage paginated list error [\#4](https://github.com/dynamic/silverstripe-recipe-book/issues/4)

**Merged pull requests:**

- RecipePage - list Primary Category in categories tab [\#30](https://github.com/dynamic/silverstripe-recipe-book/pull/30) ([jsirish](https://github.com/jsirish))
- Bugfix/category page length [\#28](https://github.com/dynamic/silverstripe-recipe-book/pull/28) ([jsirish](https://github.com/jsirish))
- RecipePage - RelatedRecipes - traverse additional categories [\#27](https://github.com/dynamic/silverstripe-recipe-book/pull/27) ([jsirish](https://github.com/jsirish))
- refactor - replace RecipeList and RecipeCategory with RecipeCategoryPage [\#23](https://github.com/dynamic/silverstripe-recipe-book/pull/23) ([jsirish](https://github.com/jsirish))
- RecipeListPage - exclude categories already selected [\#20](https://github.com/dynamic/silverstripe-recipe-book/pull/20) ([jsirish](https://github.com/jsirish))
- RecipeCategory - $ListLink [\#19](https://github.com/dynamic/silverstripe-recipe-book/pull/19) ([jsirish](https://github.com/jsirish))
- RecipePage - Servings as Varchar [\#18](https://github.com/dynamic/silverstripe-recipe-book/pull/18) ([jsirish](https://github.com/jsirish))
- RecipeDirection - Title as HTMLText [\#17](https://github.com/dynamic/silverstripe-recipe-book/pull/17) ([jsirish](https://github.com/jsirish))
- BUGFIX RecipeListPage now has\_one Category [\#16](https://github.com/dynamic/silverstripe-recipe-book/pull/16) ([muskie9](https://github.com/muskie9))
- RecipeList - CategoryID field [\#8](https://github.com/dynamic/silverstripe-recipe-book/pull/8) ([jsirish](https://github.com/jsirish))
- RecipeList - has\_one Category [\#7](https://github.com/dynamic/silverstripe-recipe-book/pull/7) ([jsirish](https://github.com/jsirish))
- RecipeLanding - use statement for PaginatedList [\#6](https://github.com/dynamic/silverstripe-recipe-book/pull/6) ([jsirish](https://github.com/jsirish))
- Bugfix/recipe list pagination [\#5](https://github.com/dynamic/silverstripe-recipe-book/pull/5) ([jsirish](https://github.com/jsirish))
- initial tests [\#3](https://github.com/dynamic/silverstripe-recipe-book/pull/3) ([jsirish](https://github.com/jsirish))
- RecipePage - adds Weight [\#2](https://github.com/dynamic/silverstripe-recipe-book/pull/2) ([jsirish](https://github.com/jsirish))
- RecipeLanding, Controllers [\#1](https://github.com/dynamic/silverstripe-recipe-book/pull/1) ([jsirish](https://github.com/jsirish))



\* *This Changelog was automatically generated by [github_changelog_generator](https://github.com/github-changelog-generator/github-changelog-generator)*
