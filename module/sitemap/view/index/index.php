<ul>
	<?php foreach($this->getHierarchy() as $parentId => $childIds): ?>
		<li>
			<a href="<?php echo helper::baseUrl() . $parentId; ?>"><?php echo $this->getData(['page', $parentId, 'title']); ?></a>
			<ul>
				<?php foreach($childIds as $childId): ?>
					<li>
						<a href="<?php echo helper::baseUrl() . $childId; ?>"><?php echo $this->getData(['page', $childId, 'title']); ?></a>
					</li>
				<?php endforeach; ?>
			</ul>
		</li>
	<?php endforeach; ?>
</ul>