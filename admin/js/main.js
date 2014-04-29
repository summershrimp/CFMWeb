function del(url) {
	var DOM;
	DOM = "<div id='wall'></div>";
	jQuery("#content").append(DOM);
	DOM = "<div class='ensuredel' id='ensuredel'></div>";
	jQuery("#wall").append(DOM);
	jQuery("#ensuredel").fadeOut(0);
	DOM = "<p style='margin-left:20px;margin-right:20px;'>确定删除该条记录么？</p>";
	jQuery("#ensuredel").append(DOM);
	DOM = "<div class='psubmit' id='psubmit'></div>";
	jQuery("#ensuredel").append(DOM);
	DOM = "<a href='" + url + "'><input class='button dangerousbutton' type='button' value='确定'></a>";
	jQuery("#psubmit").append(DOM);
	DOM = "<input class='button' type='button' onclick='javascript:hide()' value='取消'>";
	jQuery("#psubmit").append(DOM);
	jQuery("#ensuredel").fadeIn(250);
}
function dels() {
	var DOM;
	DOM = "<div id='wall'></div>";
	jQuery("#content").append(DOM);
	DOM = "<div class='ensuredel' id='ensuredel'></div>";
	jQuery("#wall").append(DOM);
	jQuery("#ensuredel").fadeOut(0);
	DOM = "<p style='margin-left:20px;margin-right:20px;'>确定删除这些记录么？</p>";
	jQuery("#ensuredel").append(DOM);
	DOM = "<div class='psubmit' id='psubmit'></div>";
	jQuery("#ensuredel").append(DOM);
	DOM = "<input class='button dangerousbutton' type='button' onclick='javascript:dodels()' value='确定'></a>";
	jQuery("#psubmit").append(DOM);
	DOM = "<input class='button' type='button' onclick='javascript:hide()' value='取消'>";
	jQuery("#psubmit").append(DOM);
	jQuery("#ensuredel").fadeIn(250);
}
function dodels() {
	jQuery("#del").submit();
}
function hide() {
	jQuery("#ensuredel").fadeOut(250, function() {
		jQuery("#ensuredel").remove();
		jQuery("#wall").remove();
	});
}
function ajax(id, page, row, content, ignore) {
	if (content == "") {
		return;
	}
	var xmlhttp;
	if (window.XMLHttpRequest) {
		xmlhttp=new XMLHttpRequest();
	}
	else {
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById(id).innerHTML = xmlhttp.responseText;
		}
		else {
			document.getElementById(id).innerHTML = "查找中……";
		}
	}
	xmlhttp.open("GET", "?action=ajax&page=" + page + "&row=" + row + "&content=" + content + "&ignore=" + ignore, true);
	xmlhttp.send();
}
