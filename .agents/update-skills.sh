#!/bin/bash

# Define the specific skills you care about
SKILLS=( php-pro vue-expert terraform-engineer cloud-architect devops-engineer database-optimizer api-designer architecture-designer code-reviewer code-documenter security-reviewer )

echo "Fetching latest skills..."
rm -rf /tmp/claude-skills
git clone --depth 1 https://github.com/Jeffallan/claude-skills.git /tmp/claude-skills

for skill in "${SKILLS[@]}"; do
    echo "Updating $skill..."
    cp -r /tmp/claude-skills/skills/$skill ./skills/
done

rm -rf /tmp/claude-skills
echo "Skills updated successfully!"
