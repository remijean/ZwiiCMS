<?php foreach($this->getHierarchy() as $parentId => $childIds): ?>
	<li>
		<a href="#<?php echo $parentId; ?>"><?php echo $this->getData(['page', $parentId, 'title']); ?></a>
		<ul>
			<?php foreach($childIds as $childId): ?>
				<li>
					<a href="#<?php echo $childId; ?>"><?php echo $this->getData(['page', $childId, 'title']); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</li>
<?php endforeach; ?>