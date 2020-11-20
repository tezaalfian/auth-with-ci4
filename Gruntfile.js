module.exports = function (grunt) {
	grunt.initConfig({
		concat: {
			css: {
				src: [
					"public/assets/css/bootstrap.min.css",
					"public/assets/css/atlantis.css"
				],
				dest: "public/assets/build/css/style.css",
			},
			js: {
				src: [
					"public/assets/js/core/jquery.3.2.1.min.js",
					"public/assets/js/core/bootstrap.min.js",
					"public/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js",
					"public/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js",
					"public/assets/js/plugin/datatables/datatables.min.js",
					"public/assets/js/plugin/sweetalert/sweetalert.min.js",
					"public/assets/js/atlantis.min.js"
				],
				dest: "public/assets/build/js/script.js",
			},
		},
		uglify: {
			dist: {
				src: "public/assets/build/js/script.js",
				dest: "public/assets/build/js/script.min.js",
			},
		},
		cssmin: {
			dist: {
				src: "public/assets/build/css/style.css",
				dest: "public/assets/build/css/style.min.css",
			},
		},
	});

	grunt.loadNpmTasks("grunt-contrib-cssmin");
	grunt.loadNpmTasks("grunt-contrib-concat");
	grunt.loadNpmTasks("grunt-contrib-uglify");
};
