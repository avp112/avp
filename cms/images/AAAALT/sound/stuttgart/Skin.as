import com.flashlib.util.Delegate;

import de.marcreichelt.emff.EMFF;
import de.marcreichelt.emff.UpdateUtil;

import de.marcreichelt.emff.configuration.ConfigurationFlashVars;

/**
 * The "stuttgart" skin. Based on skin "lila" from Marc Reichelt.
 * 
 * @version  0.0.1
 * @author   Mario Ernst @ Netzgiganten, grafics by Nicole Geller @ Netzgiganten (www.netzgiganten.de)
 */
class Skin {
	
	private static var skin : Skin = null;
	
	private var emff : EMFF = null;
	
	private var playMC : MovieClip = null;
	private var pauseMC : MovieClip = null;
	private var stopMC : MovieClip = null;
	private var loadprogressMC : MovieClip = null;
	private var loadprogressbarMC : MovieClip = null;
	private var playprogressMC : MovieClip = null;
	private var volumeMC : MovieClip = null;
	private var volumebarMC : MovieClip = null;
	private var loadprogressLength : Number = -1;
	private var playprogressYoffset : Number = -1;
	private var volumeYoffset : Number = -1;
	
	private var draggingPosition : Boolean = false;
	private var draggingVolume : Boolean = false;
	
	
	/**
	 * Main method that simply creates a new skin.
	 */
	public static function main() : Void {
		
		if (UpdateUtil.getInstance().updateNeeded()) {
			return;
		}
		
		skin = new Skin();
	}
	
	/**
	 * Initialization of this skin.
	 */
	private function Skin() {
		// read configuration and create new player
		emff = new EMFF( new ConfigurationFlashVars() );
		
		// save
		playMC = _root.playMC;
		pauseMC = _root.pauseMC;
		stopMC = _root.stopMC;
		loadprogressMC = _root.loadprogressMC;
		loadprogressbarMC = _root.loadprogressbarMC;
		playprogressMC = _root.playprogressMC;
		volumeMC = _root.volumeMC;
		volumebarMC = _root.volumebarMC;
		
		loadprogressLength = loadprogressMC._width;
		playprogressYoffset = playprogressMC._y;
		volumeYoffset = volumeMC._y;
		
		
		var emff : EMFF = this.emff;
		
		// set actions
		playMC.onRelease = Delegate.create(emff, emff.play);
		pauseMC.onRelease = Delegate.create(emff, emff.pause);
		stopMC.onRelease = Delegate.create(emff, emff.stop);
		
		// init width of progress bars and draggers
		volumeMC._x = volumebarMC._x + Math.round(emff.getVolume() / 100 * volumebarMC._width - volumeMC._width);
		playprogressMC._x = loadprogressbarMC._x;
		playprogressMC._visible = false;
		
		playprogressMC.onPress = Delegate.create(this, pressPlayprogressMC);
		playprogressMC.onRelease = Delegate.create(this, releasePlayprogressMC);
		playprogressMC.onReleaseOutside = playprogressMC.onRelease;
		volumeMC.onPress = Delegate.create(this, pressVolumeMC);
		volumeMC.onRelease = Delegate.create(this, releaseVolumeMC);
		
		_root.onEnterFrame = Delegate.create(this, enterFrame);
	}
	
	
	/**
	 * 
	 */
	private function pressPlayprogressMC() : Void {
		draggingPosition = true;
		emff.pause();
		playprogressMC.startDrag(
			false,
			loadprogressbarMC._x,
			playprogressYoffset,
			loadprogressbarMC._x + loadprogressbarMC._width - playprogressMC._width,
			playprogressYoffset
		);
	}
	
	/**
	 * 
	 */
	private function releasePlayprogressMC() : Void {
		draggingPosition = false;
		playprogressMC.stopDrag();
		var selected : Number = (playprogressMC._x - loadprogressbarMC._x) / (loadprogressbarMC._x + loadprogressbarMC._width - playprogressMC._width);
		if (selected > emff.getLoadingProgress()) {
			// we can not select more than what is loaded yet
			selected = emff.getLoadingProgress();
		}
		emff.setRelativePosition(selected);
		emff.play();
	}
	
	/**
	 * 
	 */
	private function pressVolumeMC() : Void {
		draggingVolume = true;
		volumeMC.startDrag(false, volumebarMC._x, volumeYoffset, volumebarMC._x + volumebarMC._width - volumeMC._width, volumeYoffset);
	}
	
	/**
	 * 
	 */
	private function releaseVolumeMC() : Void {
		draggingVolume = false;
		volumeMC.stopDrag();
	}
	
	/**
	 * Method that is activated every frame and will refresh the visualisation.
	 */
	private function enterFrame() : Void {
		if (emff.getStatus() == EMFF.STOPPED) {
			playprogressMC._visible = false;
		} else {
			playprogressMC._visible = true;
		}
		
		loadprogressMC._width = emff.getLoadingProgress() * loadprogressLength;
		
		if (!draggingPosition) {
			playprogressMC._x = Math.round(loadprogressbarMC._x + emff.getPlayingProgress() * (loadprogressbarMC._width - playprogressMC._width));
		}
		
		if (draggingVolume) {
			emff.setVolume(Math.round((volumeMC._x - volumebarMC._x) / (volumebarMC._width - volumeMC._width) * 100));
		}
	}
	
}
