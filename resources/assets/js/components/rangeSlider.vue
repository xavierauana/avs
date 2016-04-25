<template>
    <p>
        <label for="amount" id="range-label">Price range: {{start}} - {{end}}</label>
        <div>
            <input type="text" id="amount" class="sr-only" readonly
                   style="border:0; color:#f6931f; font-weight:bold;"/>
            <div id="slider"></div>
        </div>
    </p>
</template>

<script>
    export default{
        props: ['start', 'end'],
        data: function(){
            return {
                theSlider: {},
                lowerBound:"",
                upperBound:""
            }
        },
        watch: {
            start: function (value) {
                this.theSlider.slider("option", "min", parseInt(value));
                this.theSlider.slider("values",0, value);
            },
            end: function (value) {
                this.theSlider.slider("option", "max", parseInt(value));
                this.theSlider.slider("values",1, value);
            }
        },
        ready: function () {
            var self = this;
            this.$set("theSlider", $("#slider"));
            this.theSlider.slider({
                range: true,
                min: parseInt(self.lowerBound),
                max: parseInt(self.upperBound),
                values: [self.start,self.end],
                slide: function (event, ui) {
                    var label = document.getElementById('range-label');
                    label.innerText = "";
                    var text = document.createTextNode("Price range: " + ui.values[0] + " - " + ui.values[1]);
                    label.appendChild(text);
                    self.$dispatch("sliderStartChange", ui.values[0]);
                    self.$dispatch("sliderEndChange", ui.values[1]);
                }
            });
        }
    }
</script>