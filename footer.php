<?php function get_footer(){ ?>
<hr>
<div class="footer">
	<p>
		© <a href="<?php echo URL; ?>" title="<?php echo NAME; ?>" target="_blank"><?php echo NAME; ?></a>
		<a href="http://www.flydev.cc/" title="黑科技" target="_blank">黑科技</a>
		<a href="http://bbs.flydev.cc/" title="LiveFace社区" target="_blank">LiveFace社区</a>
		<a href="http://ui.flydev.cc/" title="LiveFace官网" target="_blank">LiveFace官网</a>
	</p>
Processed in 
<?php 
$load = microtime();
print (number_format($load,5));
?> second(s)
</div>
</div>
</body>
</html>
<?php } ?>