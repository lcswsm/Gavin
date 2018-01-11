/* 
 * Admin模块js文件
 */
new Vue({
    el:"adminList",
    data:{
        items:[],
        loaded:false
    },
    
    methods: {
        btnClick: function() {
            $.ajax({
                type: "post",
                url: "/Index/getAdmin",
                async: true,
                success: function(data) {
                    vm.name = data.name;
                },
            });
        },
        
        bodyLoaded: function() {
            $.ajax({
                type: "post",
                url: "/Index/getAdmin",
                async: true,
                success: function(data) {
                    vm.name = data.name;
                },
            });
        }
    }
});
