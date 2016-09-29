<h1>Plan du site</h1>
<?php foreach($this->getHierarchy() as $parentId => $childIds): ?>
	<li>
		<a href="#<?php echo $parentId; ?>"><?php echo $this->getData(['page', $parentId, 'name']); ?></a>
		<ul>
			<?php foreach($childIds as $childId): ?>
				<li>
					<a href="#<?php echo $childId; ?>"><?php echo $this->getData(['page', $childId, 'name']); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
	</li>
<?php endforeach; ?>