    <p class="col-sm-6" v-if="pagination.total"><span>Displaying @{{ pagination.from }} to @{{ pagination.to }}
            of @{{ pagination.total }}</span></p>

    <div class="col-sm-6">
        <ul class="pagination pull-right" v-if="pagination.total > 15">
            <!-- Previous Page Link -->
            <li class="disabled" v-if="pagination.current_page === 1"><span><i
                            class="fa fa-arrow-left"></i></span></li>
            <li v-else><a href="#" @click.prevent="prev" rel="prev"><i class="fa fa-arrow-left"></i></a></li>

            <!-- Next Page Link -->
            <li v-if="pagination.current_page !== pagination.last_page">
                <a href="#" @click.prevent="next" rel="next"><i class="fa fa-arrow-right"></i></a>
            </li>
            <li class="disabled" v-else><span><i class="fa fa-arrow-right"></i></span></li>
        </ul>
    </div>