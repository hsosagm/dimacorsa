<div id="back-top" class="animated pulse circle">
    <i class="fa fa-angle-up"></i>
</div><!-- /#back-top -->

<script src="http://localhost:4000/js/main.js"></script>


<script>

    $(document).ready(function() {

        $.ui.autocomplete.prototype._renderItem = function (ul, item) {
            var term = this.term.split(' ').join('|');
            var re = new RegExp("(" + term + ")", "gi");
            var t = item.label.replace(re, "<b class='hiligth'>$1</b>");
            return $("<li></li>")
            .data("item.autocomplete", item)
            .append("<a>" + t + "</a>")
            .appendTo(ul);
        };
    });

</script> 