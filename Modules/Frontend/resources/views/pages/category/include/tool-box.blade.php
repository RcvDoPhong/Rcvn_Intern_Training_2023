 <div id="stick_here"></div>
 <div class="toolbox elemento_stick">
     <div class="container">
         <ul class="clearfix">
             <li>
                 <div class="sort_select">
                     <select name="sort" id="sort-category">
                         <option value="name">Sort by A-Z name</option>
                         <option value="name-desc">Sort by Z-A name</option>
                         <option value="rating">Sort by average rating</option>
                         <option value="date" selected="selected">Sort by newness</option>
                         <option value="price">Sort by price: low to high</option>
                         <option value="price-desc">Sort by price: high to
                     </select>
                 </div>
             </li>
             <li class="d-flex gap-2 align-items-center">
                 <div style="cursor: pointer" onclick="productView.changeProductView('grid')"><i
                         class="ti-view-grid"></i></div>
                 <div style="cursor: pointer" onclick=" productView.changeProductView('row')"><i
                         class="ti-view-list"></i></div>
             </li>
             <li>
                 <a href="#0" class="open_filters">
                     <i class="ti-filter"></i><span>Filters</span>
                 </a>
             </li>
         </ul>
     </div>
 </div>
 <!-- /toolbox -->
