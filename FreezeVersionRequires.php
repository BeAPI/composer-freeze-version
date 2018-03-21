<?php namespace BEA\ComposerInstaller;

use Composer\Script\Event;
use Composer\Json\JsonFile;

class FreezeVersionRequires {

	/**
	 * @param Event $event
	 *
	 * @author Julien Maury
	 */
	public static function freezeVersion( Event $event ) {
		// Quick access
		$io       = $event->getIO();
		$composer = $event->getComposer();

		// what is the command's purpose
		$io->write( "\nHello, this command allows you to freeze all plugins versions according to your composer.lock file." );

		if ( false === $io->askConfirmation( "Do you really want to freeze all requirement versions now (y/n) ?", true ) ) {
			exit;
		}

		// if no composer.lock file then bail
		if ( ! file_exists( self::getFile( $composer, 'composer.lock' ) ) ) {
			$io->write( "\nThere is currently no composer.lock file !" );
			exit;
		}

		$jsonFile = self::getFile( $composer, 'composer.json' );

		// if we cannot write then bail
		if ( ! is_writeable( $jsonFile ) ) {
			$io->write( "\nThe composer.json file cannot be rewritten ! Please check your file permissions." );
			exit;
		}

		// everything is ok, launch
		$io->write( "\nGreat ! Let's dot it !" );
		$cmd = self::getData( $composer );

		// If no packages then bail
		if ( ! isset( $cmd->packages ) ) {
			$io->write( "\nThere is nothing to retrieve from composer lock require part." );
			exit;
		}

		self::rewriteRequire( $composer, $cmd->packages );
		$io->write( "\nAll required versions have been freezed \o/" );
	}

	/**
	 * @param $composer
	 * @param array $packages
	 *
	 * @author Julien Maury
	 * @return bool
	 */
	public static function rewriteRequire( $composer, $packages ) {

		$content = self::getData( $composer, 'composer.json' );

		if ( ! isset( $content->require ) ) {
			return false;
		}

		foreach ( $packages as $pck ) {

			if ( ! isset( $pck->name, $pck->version, $content->require->{$pck->name} ) ) {
				continue;
			}

			$content->require->{$pck->name} = (string) $pck->version;
		}

		$json = new JsonFile( self::getFile( $composer, 'composer.json' ) );
		return $json->write( (array) $content );
	}

	/**
	 * @param $composer
	 * @param $file
	 *
	 * @return object
	 * @author Julien Maury
	 */
	protected static function getData( $composer, $file = 'composer.lock' ) {
		return json_decode( file_get_contents( self::getFile( $composer, $file ) ) );
	}

	/**
	 * Get the composer.lock file path
	 *
	 * @param Composer $composer
	 * @param $file
	 *
	 * @author Julien Maury
	 * @return string
	 */
	protected static function getFile( $composer, $file ) {
		return dirname( $composer->getConfig()->get( 'vendor-dir' ) ) . '/' . $file;
	}

}
