import { cpSync, existsSync, mkdirSync, readFileSync, readdirSync, rmSync } from 'node:fs';
import { basename, relative, resolve } from 'node:path';
import { execFileSync } from 'node:child_process';

const root = resolve(process.cwd());
const themeName = basename(root);
const releaseDir = resolve(root, 'release');
const archivePath = resolve(releaseDir, `${themeName}.zip`);
const stagingDir = resolve(releaseDir, themeName);
const distIgnorePath = resolve(root, '.distignore');

const rules = existsSync(distIgnorePath)
	? readFileSync(distIgnorePath, 'utf8')
		.split(/\r?\n/)
		.map((line) => line.trim())
		.filter((line) => line && !line.startsWith('#'))
	: [];

const normalize = (value) => value.replaceAll('\\', '/');

const isIgnored = (source) => {
	const rel = normalize(relative(root, source));

	if (!rel) {
		return false;
	}

	return rules.some((rule) => {
		const cleanRule = normalize(rule).replace(/^\//, '');

		if (cleanRule.endsWith('/')) {
			return rel === cleanRule.slice(0, -1) || rel.startsWith(cleanRule);
		}

		if (cleanRule.startsWith('*.')) {
			return rel.endsWith(cleanRule.slice(1));
		}

		return rel === cleanRule || rel.startsWith(`${cleanRule}/`);
	});
};

mkdirSync(releaseDir, { recursive: true });
rmSync(archivePath, { force: true });
rmSync(stagingDir, { recursive: true, force: true });
mkdirSync(stagingDir, { recursive: true });

readdirSync(root, { withFileTypes: true }).forEach((entry) => {
	const source = resolve(root, entry.name);
	const destination = resolve(stagingDir, entry.name);

	if (source === releaseDir || isIgnored(source)) {
		return;
	}

	cpSync(source, destination, {
		recursive: true,
		filter: (childSource) => !isIgnored(childSource),
	});
});

execFileSync('powershell.exe', [
	'-NoProfile',
	'-Command',
	`Compress-Archive -Path "${stagingDir}" -DestinationPath "${archivePath}" -Force`,
], { cwd: releaseDir, stdio: 'inherit' });

rmSync(stagingDir, { recursive: true, force: true });

console.log(`Created ${archivePath}`);
